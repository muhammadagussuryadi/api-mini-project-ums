<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PelangganModel;
use Validator;

class PelangganController extends Controller
{
    public function __construct(){

    }

    public function index(){
        $data = PelangganModel::all();
        return response()->json(["statusCode"=>200, "message"=>"success", "data"=> $data],200);
    }

    public function getById($id){
        $data = PelangganModel::where('id_pelanggan',$id)->get();
        return response()->json(["statusCode"=>200, "message"=>"success", "data"=> $data],200);
    }

    public function submit(Request $request){

        $post['nama'] = $request->nama;
        $post['domisili'] = $request->domisili;
        $post['jenis_kelamin'] = $request->jenis_kelamin;
        if($request->id_pelanggan){
            $save = PelangganModel::where('id_pelanggan',$request->id_pelanggan)->update($post);
        }else{
            $post['id_pelanggan'] = $this->generateIdPelanggan();;
            $save = PelangganModel::create($post);
        }
        if($save){
            return response()->json(["statusCode"=>200, "message"=>"success"],200);
        }else{
            return response()->json(["statusCode"=>500, "message"=>"error"],200);
        }

    }

    public function generateIdPelanggan()
    {
      $number = PelangganModel::count();
      do {
        $number ++;
      } while (
        PelangganModel::where("id_pelanggan", "=", "PELANGGAN_".$number)->first()
    );
      return "PELANGGAN_".$number;
    }

    public function delete($id){
        $data = PelangganModel::where('id_pelanggan',$id);
        if($data->delete()){
            return response()->json(["statusCode"=>200, "message"=>"success"],200);
        }else{
            return response()->json(["statusCode"=>500, "message"=>"error"],200);
        }
    }
}
