<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;

use Validator;
use Cache;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $_category)
    {
        $this->category = $_category;
    }
    
    public function index(Request $request)
    {
        $categoryType = [Category::COMMON_TYPE => trans('admin_common.Common Type'),
            Category::REAL_ESTATE_TYPE => trans('admin_common.Real Estate Type'),
            Category::CARS_TYPE => trans('admin_common.Cars Type'),
            Category::SERVICES_TYPE => trans('admin_common.Services Type'),
            Category::CLOTHES_TYPE => trans('admin_common.Clothes Type'),
            Category::SHOES_TYPE => trans('admin_common.Shoes Type'),
            Category::REAL_ESTATE_LAND_TYPE => trans('admin_common.Real Estate Land Type'),
        ];
        return view('admin.category.category_list', ['category_list' => $this->category->getAllHierarhy(null, 0, 0), 'categoryType' => $categoryType]);
    }
    
    public function edit(Request $request)
    {
        $allCategoryHierarhy = $this->category->getAllHierarhy(null, 0, 0);
        $categoryType = [Category::COMMON_TYPE => trans('admin_common.Common Type'),
            Category::REAL_ESTATE_TYPE => trans('admin_common.Real Estate Type'),
            Category::CARS_TYPE => trans('admin_common.Cars Type'),
            Category::SERVICES_TYPE => trans('admin_common.Services Type'),
            Category::CLOTHES_TYPE => trans('admin_common.Clothes Type'),
            Category::SHOES_TYPE => trans('admin_common.Shoes Type'),
            Category::REAL_ESTATE_LAND_TYPE => trans('admin_common.Real Estate Land Type'),
        ];

        $id = 0;
        if(isset($request->id)){
            $id = $request->id;
        }

        $modelData = new \stdClass();
        if($id > 0){
            try{
                $modelData = Category::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', trans('admin_common.Invalid Category'));
                return redirect(url('admin/category'));
            }
        }

        $cid = 0;
        if(isset($modelData->category_parent_id) && $modelData->category_parent_id > 0){
            $cid = $modelData->category_parent_id;
        }

        /**
         * form is submitted check values and save if needed
         */
        if ($request->isMethod('post')) {

            $data = $request->all();

            /**
             * validate data
             */
            $rules = [
                'category_title' => 'required|max:255',
                'category_slug' => 'required|max:255|unique:category,category_slug',
                'category_type' => 'required|integer',
                'category_ord' => 'required|integer'
            ];

            if(isset($modelData->category_id)){
                $rules['category_slug'] = 'required|max:255|unique:category,category_slug,' . $modelData->category_id  . ',category_id';
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }

            /**
             * get data from form
             */
            $data = $request->all();

            /**
             * check for uploaded icon
             */
            $name = '';
            if ($request->hasFile('icon_file') && $request->file('icon_file')->isValid()) {
                $file = Input::file('icon_file');
                $name = time() . '_cicon.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/uf/cicons', $name);
                $data['category_img'] = $name;
            }

            /**
             * save data if validated
             */
            if(isset($data['category_active'])){
                $data['category_active'] = 1;
            } else {
                $data['category_active'] = 0;
            }
            if($data['category_parent_id'] == 0){
                unset($data['category_parent_id']);
            }

            /**
             * save or update
             */
            if(!isset($modelData->category_id)){
                Category::create($data);
            } else {
                if(!empty($name) && !empty($modelData->category_img)){
                    @unlink(public_path() . '/uf/cicons/' . $modelData->category_img);
                }
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', trans('admin_common.Category saved'));
            return redirect(url('admin/category'));
        }

        return view('admin.category.category_edit', ['c' => $allCategoryHierarhy,
            'modelData' => $modelData,
            'cid' => $cid,
            'categoryType' => $categoryType]);
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
            $data = $request->input('category_id');
        }

        //delete
        if(!empty($data)){
            foreach ($data as $k => $v){
                $c = Category::find($v);
                if(!empty($c->category_img)){
                    @unlink(public_path() . '/uf/cicons/' . $c->category_img);
                }
                $c->delete();
            }
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', trans('admin_common.Category deleted'));
            return redirect(url('admin/category'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', trans('admin_common.Nothing for deletion'));
        return redirect(url('admin/category'));
    }
    
    public function import(Request $request)
    {
        $allCategoryHierarhy = $this->category->getAllHierarhy(null, 0, 0);

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
                $tmp_import_name = time() . '_category_import_.' . $csv_file->getClientOriginalExtension();
                $csv_file->move(storage_path() . '/app', $tmp_import_name);

                //read csv
                $csv_data = [];
                if (($handle = fopen(storage_path() . '/app/' . $tmp_import_name, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",", '"')) !== FALSE) {
                        $csv_data[] = $data;
                    }
                    fclose($handle);
                }

                if(!empty($csv_data)){
                    //check if locations parent is selected
                    $category_parent_id = $request->input('category_parent_id', 0);

                    //import erros holder
                    $import_error_array = [];

                    foreach ($csv_data as $k => $v){
                        if(is_array($v) && !empty($v)){
                            $data_to_save = [];

                            //set fields to be imported
                            if(isset($v[0]) && !empty($v[0]) && (int)$v[0] > 0){
                                $data_to_save['category_type'] = (int)trim($v[0]);
                            }
                            if(isset($v[1]) && !empty($v[1])){
                                $data_to_save['category_title'] = trim($v[1]);
                            }
                            if(isset($v[2]) && !empty($v[2])){
                                $data_to_save['category_slug'] = trim($v[2]);
                            } else {
                                if(isset($data_to_save['category_title']) && !empty($data_to_save['category_title'])) {
                                    $data_to_save['category_slug'] = str_slug($data_to_save['category_title']);
                                }
                            }
                            if(isset($v[3]) && !empty($v[3]) && ($v[3] == 1 || $v[3] == 0)){
                                $data_to_save['category_active'] = $v[3];
                            } else {
                                $data_to_save['category_active'] = 1;
                            }
                            if(isset($v[4]) && !empty($v[4])){
                                $data_to_save['category_ord'] = trim($v[4]);
                            }
                            if(isset($v[5]) && !empty($v[5])){
                                $data_to_save['category_description'] = trim($v[5]);
                            }
                            if(isset($v[6]) && !empty($v[6])){
                                $data_to_save['category_keywords'] = trim($v[6]);
                            }

                            //check if all fields are here
                            if(count($data_to_save) >= 5){
                                if($category_parent_id > 0 && is_numeric($category_parent_id)){
                                    $data_to_save['category_parent_id'] = $category_parent_id;
                                }

                                try{
                                    Category::create($data_to_save);
                                } catch (\Exception $e){
                                    $import_error_array[] = trans('admin_common.Possible doublicate') .  '<strong>' . trans('admin_common.Category Slug') . '</strong>' . trans('admin_common.on line') . ': ' . join(',', $v) . ' <br />' . trans('admin_common.Error Message') . ': ' . $e->getMessage();
                                }
                            } else {
                                $import_error_array[] = trans('admin_common.Missing data line') . ': ' . join(',', $v);
                            }
                        }
                    }
                } else {
                    session()->flash('message', trans('admin_common.Cant read the csv file.'));
                    return redirect( url('admin/category') );
                }
            }
    
            /**
             * delete temp file, clear cache, set message, redirect to list
             */
            @unlink(storage_path() . '/app/' . $tmp_import_name);
            Cache::flush();
            if(!empty($import_error_array)){
                session()->flash('message', trans('admin_common.Categories imported with the following errors') . ': <br />' . join('<br />', $import_error_array));
            } else {
                session()->flash('message', trans('admin_common.Categories imported'));
            }
            return redirect(url('admin/category'));
        }

        return view('admin.category.category_import', ['c' => $allCategoryHierarhy]);
    }
}
