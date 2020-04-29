<?php

namespace App\Http\Controllers;
use Image;
use Illuminate\Http\Request;
use View;
use Gate;
use Session;


class BaseController extends Controller
{
    protected function commondata($view_path)
    {
        View::composer($view_path, function ($view) {
            $view->with('dashboard', route('dashboard'));
            $view->with('_view_path',$this->view_path);
            $view->with('_base_route',$this->base_route);
            $view->with('_panel',$this->panel);
            $view->with('_folder',property_exists($this,'folder')?$this->folder:'');
            $view->with('_databaseimage',property_exists($this,'databaseimage')?$this->databaseimage:'');
            $view->with('_folderpath',property_exists($this,'folderpath')?$this->folderpath:'');
        });
        return $view_path;
    }


    public function storeimage(Request $request, $id ='null')
    {
        if( $id == 'null')
        {
            $this->imaging($request);
        }
        else
        {
            if($request->hasFile('mainimage')){
                $this->removeimage($id);
                $this->imaging($request);
            }
        }
    }

    public function destroydata($id)
    {
        $data['base'] = $this->model->find($id);
        $this->removeimage($id);
        $this->rowExist($data['base']);
        $data['base']->delete();
    }

    public function imaging(Request $request)
    {
        if($request->hasFile('mainimage'))
        {
            $dbname = $this->databaseimage;
            $file = $request->file('mainimage');
            $dim = config('dimension.dimension-image-new.new-image-dimensions');
            $name = uniqid().'-'.$file->getClientOriginalName();
            $file->move($this->folderpath . DIRECTORY_SEPARATOR,$name);
            if($dim)
            {
                $resize_image = Image::make($this->folderpath.DIRECTORY_SEPARATOR.$name);
                $resize_image->resize($dim['width'],$dim['height']);
                $resize_image->save($this->folderpath. DIRECTORY_SEPARATOR.$dim['width'].'-'.$dim['height'].'-'.$name);
            }
            $request->mainimage = $name;
        }
    }

    public function removeimage($id)
    {
        $data['base'] = $this->model->find($id);
        $dbname = $this->databaseimage;
        $dim = config('dimension.dimension-image-new.new-image-dimensions');
        if ($data['base']->$dbname)
        {
            if(file_exists($this->folderpath . DIRECTORY_SEPARATOR.$data['base']->$dbname))
            {
                unlink($this->folderpath . DIRECTORY_SEPARATOR.$data['base']->$dbname);
                unlink($this->folderpath. DIRECTORY_SEPARATOR.$dim['width'].'-'.$dim['height'].'-'.$data['base']->$dbname);
            }
        }
    }

    public function statuschange($id)
    {
        $data['base'] = $this->model->find($id);
        if ($data['base']->status == 0)
        {
            $data['base']->status = 1;
        }
        else
        {
            $data['base']->status = 0;
        }
        $data['base']->save();
        Session::flash('success','Status Update Successfully');
    }

    public function rowExist($row){
        if(!$row){
            Session::flash('warning','Invalid Request');
            return redirect()->route($this->base_route)->send();
        }
    }

    public function checkDirectory()
    {
        if(!file_exists(public_path($this->folderpath))){
            mkdir(public_path($this->folderpath));
        }
    }
}

