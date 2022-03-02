<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PenjualanModel;
use App\Models\PelangganModel;
use App\Models\ItemPenjualanModel;
use Validator;
use DB;

class PenjualanController extends Controller
{
    public function __construct(){

    }

    public function index(){
        $data = PenjualanModel::all();
        foreach ($data as $key => $value) {
            $data[$key]->item_penjualan = $this->getItemPenjualan($value->id_nota);
        }
        return response()->json(["statusCode"=>200, "message"=>"success", "data"=> $data],200);
    }

    private function getItemPenjualan($id_nota){
        $data = DB::table('tb_item_penjualan')
                ->select('tb_item_penjualan.*', 'tb_barang.nama AS nama_barang', 'tb_barang.harga AS harga_barang')
                ->join('tb_barang', 'tb_barang.kode', '=', 'tb_item_penjualan.kode_barang')
                ->where('tb_item_penjualan.nota', '=', $id_nota)
                ->get();
        // $data = ItemPenjualanModel::where('nota', $id_nota)->get();
        return $data;
    }

    public function submit(Request $request){

        $cekPelanggan = PelangganModel::where('id_pelanggan',$request->kode_pelanggan)->first();
        if($cekPelanggan){
            $post['kode_pelanggan'] = $request->kode_pelanggan;
            $post['subtotal'] = $request->subtotal;
            $post['tgl'] = date('Y-m-d');
            $itemPenjualan = $request->item_penjualan;
            if($request->id_nota){
                $save = PenjualanModel::where('id_nota',$request->id_nota)->update($post);
            }else{
                $post['id_nota'] = $this->generateIdNota();
                $save = PenjualanModel::create($post);
            }
            if($save){
                foreach ($itemPenjualan as $key => $value) {
                    $postItem['nota'] = ($request->id_nota? $request->id_nota :$post['id_nota']);
                    $postItem['kode_barang'] = $value['kode_barang'];
                    $postItem['qty'] = $value['qty'];
                    $saveItem = ItemPenjualanModel::create($postItem);
                }

                return response()->json(["statusCode"=>200, "message"=>"success"],200);
            }else{
                return response()->json(["statusCode"=>500, "message"=>"error"],200);
            }
        }else{
            return response()->json(["statusCode"=>500, "message"=>"error"],200);
        }
    }

    public function generateIdNota()
    {
      $number = PenjualanModel::count();
      do {
        $number ++;
      } while (
        PenjualanModel::where("id_nota", "=", "NOTA_".$number)->first()
    );
      return "NOTA_".$number;
    }

    public function delete($id){
        $data = PenjualanModel::where('id_nota',$id);
        if($data->delete()){
            return response()->json(["statusCode"=>200, "message"=>"success"],200);
        }else{
            return response()->json(["statusCode"=>500, "message"=>"error"],200);
        }
    }
}
