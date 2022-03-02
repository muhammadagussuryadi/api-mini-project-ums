<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BarangModel;
use Validator;

class BarangController extends Controller
{
    public function __construct(){

    }

    public function index(){
        $data = BarangModel::all();
        return response()->json(["statusCode"=>200, "message"=>"success", "data"=> $data],200);
    }

    public function getById($id){
        $data = BarangModel::where('kode',$id)->get();
        return response()->json(["statusCode"=>200, "message"=>"success", "data"=> $data],200);
    }

    public function submit(Request $request){

        $post['nama'] = $request->nama;
        $post['kategori'] = $request->kategori;
        $post['harga'] = $request->harga;
        if($request->kode){
            $save = BarangModel::where('kode',$request->kode)->update($post);
        }else{
            $post['kode'] = $this->generateIdBarang();
            $save = BarangModel::create($post);
        }
        if($save){
            return response()->json(["statusCode"=>200, "message"=>"success"],200);
        }else{
            return response()->json(["statusCode"=>500, "message"=>"error"],200);
        }

    }

    public function generateIdBarang()
    {
      $number = BarangModel::count();
      do {
        $number ++;
      } while (
        BarangModel::where("kode", "=", "BRG_".$number)->first()
    );
      return "BRG_".$number;
    }

    public function delete($id){
        $data = BarangModel::where('kode',$id);
        if($data->delete()){
            return response()->json(["statusCode"=>200, "message"=>"success"],200);
        }else{
            return response()->json(["statusCode"=>500, "message"=>"error"],200);
        }
    }
}
