<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Location;

use Validator;
use Cache;

class LocationController extends Controller
{
	protected $location;
	
	public function __construct(Location $_location)
    {
    	$this->location = $_location;
    }
    
	public function index(Request $request)
    {
    	return view('admin.location.location_list', ['location_list' => $this->location->getAllHierarhy(null, 0, 0)]);
    }
    
    public function edit(Request $request)
    {
    	$allLocationHierarhy = $this->location->getAllHierarhy(null, 0, 0);
    	$id = 0;
    	if(isset($request->id)){
    		$id = $request->id;
    	}
    	
    	$modelData = new \stdClass();
    	if($id > 0){
    		try{
    			$modelData = Location::findOrFail($id);
    		} catch (ModelNotFoundException $e){
    			session()->flash('message', 'Invalid Location');
    			return redirect(url('admin/location'));
    		}
    	}
    	
    	$lid = 0;
    	if(isset($modelData->location_parent_id) && $modelData->location_parent_id > 0){
    		$lid = $modelData->location_parent_id;
    	}
    	
    	/**
    	 * form is submitted check values and save if needed
    	 */
    	if ($request->isMethod('post')) {
    		
    		/**
    		 * validate data
    		 */
    		$rules = [
    			'location_name' => 'required|max:255',
    			'location_slug' => 'required|max:255|unique:location,location_slug'
    		];
    		
    		if(isset($modelData->location_id)){
    			$rules['location_slug'] = 'required|max:255|unique:location,location_slug,' . $modelData->location_id  . ',location_id';
    		}
    		 
    		$validator = Validator::make($request->all(), $rules);
    		if ($validator->fails()) {
    			$this->throwValidationException(
    				$request, $validator
    			);
    		}
    		
    		/**
    		 * save data if validated
    		 */
    		//no location selected, create new location
    		if(!isset($modelData->location_id)){
    			$location = new Location();
    			$location->location_name = $request->location_name;
    			$location->location_slug = $request->location_slug;
    			$location->location_active = 0;
    			if($request->location_active){
    				$location->location_active = 1;
    			}
    			if($request->location_parent_id){
    				$location->location_parent_id = $request->location_parent_id;
    			}
    			$location->save();
    		} else {
    			$data = $request->all();
    			if(isset($data['location_active'])){
    				$data['location_active'] = 1;
    			} else {
    				$data['location_active'] = 0;
    			}
    			$modelData->update($data);
    		}
    		
    		/**
    		 * clear cache, set message, redirect to list
    		 */
    		Cache::flush();
    		session()->flash('message', 'Location saved');
    		return redirect(url('admin/location'));
    	}
    	
    	return view('admin.location.location_edit', ['l' => $allLocationHierarhy,
    		'modelData' => $modelData,
    		'lid' => $lid]);
    }
    
    public function delete(Request $request)
    {
    	//locations to be deleted
    	$data = [];
    	
    	//check for single delete
    	if(isset($request->id)){
    		$data[] = $request->id;
    	}
    	
    	//check for mass delete if no single delete
    	if(empty($data)){
    		$data = $request->input('location_id');
    	}
    	
    	//delete
    	if(!empty($data)){
    		Location::destroy($data);
    		//clear cache, set message, redirect to list
    		Cache::flush();
    		session()->flash('message', 'Location deleted');
    		return redirect(url('admin/location'));
    	}
    	
    	//nothing for deletion set message and redirect
    	session()->flash('message', 'Nothing for deletion');
    	return redirect(url('admin/location'));
    }
    
    public function import(Request $request)
    {
    	$allLocationHierarhy = $this->location->getAllHierarhy(null, 0, 0);
    	 
    	/**
    	 * form is submitted check values and save if needed
    	 */
    	if ($request->isMethod('post')) {
    		
    		/**
    		 * validate data
    		 */
    		$rules = ['csv_file' => 'required'];
    		$validator = Validator::make($request->all(), $rules);
    		if ($validator->fails()) {
    			$this->throwValidationException(
    				$request, $validator
    			);
    		}
    
    		/**
    		 * save data if validated
    		 */
    		if ($request->file('csv_file')->isValid()) {
    			
    			//rename and move uploaded file
    			$csv_file = Input::file('csv_file');
    			$tmp_import_name = time() . '_location_import_.' . $csv_file->getClientOriginalExtension();
    			$csv_file->move(storage_path() . '/app', $tmp_import_name);
    			
    			//read csv
    			$csv_data = [];
				if (($handle = fopen(storage_path() . '/app/' . $tmp_import_name, "r")) !== FALSE) {
					while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
						$csv_data[] = $data;
					}
					fclose($handle);
				}
				
				if(!empty($csv_data)){
					//check if locations parent is selected
					$location_parent_id = $request->input('location_parent_id', 0);
					
					//import erros holder
					$import_error_array = [];
					
					foreach ($csv_data as $k => $v){
						if(is_array($v)){
							$data_to_save = [];
							
							//set fields to be imported
							if(isset($v[0]) && !empty($v[0])){
								$data_to_save['location_name'] = trim($v[0]);
							}
							if(isset($v[1]) && !empty($v[1])){
								$data_to_save['location_slug'] = trim($v[1]);
							} else {
								$data_to_save['location_slug'] = str_slug($data_to_save['location_name']);
							}
							if(isset($v[2]) && !empty($v[2]) && ($v[2] == 1 || $v[2] == 0)){
								$data_to_save['location_active'] = $v[2];
							} else {
								$data_to_save['location_active'] = 1;
							}
							
							//check if all fields are here
							if(count($data_to_save) == 3){
								if($location_parent_id > 0 && is_numeric($location_parent_id)){
									$data_to_save['location_parent_id'] = $location_parent_id;
								}
								
								try{
									Location::create($data_to_save);
								} catch (\Exception $e){
									$import_error_array[] = 'Possible doublicate <strong>Location Slug</strong> on line: ' . join(',', $v) . ' <br />Error Message: ' . $e->getMessage();
								}
							} else {
								$import_error_array[] = 'Missing data line: ' . join(',', $v);
							}
						}
					}
				} else {
					session()->flash('message', 'Can\'t read the csv file.');
					return redirect( url('admin/location') );
				}
    		}
    
    		/**
    		 * delete temp file, clear cache, set message, redirect to list
    		 */
    		@unlink(storage_path() . '/app/' . $tmp_import_name);
    		Cache::flush();
    		if(!empty($import_error_array)){
    			session()->flash('message', 'Locations imported with the following errors: <br />' . join('<br />', $import_error_array));
    		} else {
    			session()->flash('message', 'Locations imported');
    		}
    		return redirect(url('admin/location'));
    	}
    	 
    	return view('admin.location.location_import', ['l' => $allLocationHierarhy]);
    }
}
