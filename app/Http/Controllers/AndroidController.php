<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use \App\Comment;

class AndroidController extends Controller
{
    // token = await fetch("/android/token");
    // await (await fetch("/android/comments", { method: "post", body: {}, headers: { "X-CSRF-TOKEN": await token.text() } })).text();
    //------------------------------------------

    private const PAGE_SIZE = 5;

    private function error(\Exception &$e){
        return response("Server error: " . $e->getMessage(), 500);
    }

    private function convertDates(&$table){
        foreach ($table as &$m) {
            //error_log($m->created_at . " -> " . strtotime($m->created_at));
            $m->created_at = strtotime($m->created_at);
            $m->updated_at = strtotime($m->updated_at);
        }
    }
    
    private function authenticate()
    {
        return true;
    }

    //------------------------------------------
    // get data

    public function locations(){
        try{
            $timestamp = request("timestamp")?? 0;
            $date = date("Y-m-d H:i:s", $timestamp);
        
            $table = DB::connection()->table("locations")->where([
                ["show","=",true],
                ["updated_at",">=",$date]
            ])->get();
           
            $this->convertDates($table);
            return $table;
        }catch(\Exception $e){
            return $this->error($e);
        }
    }

    public function zones(){
        try{
            $timestamp = request("timestamp")?? 0;
            $date = date("Y-m-d H:i:s", $timestamp);

        
            $table = DB::connection()->table("zones")->where([
                ["show","=",true],
                ["updated_at",">=",$date]
            ])->get();

            
            foreach($table as &$zone){
                $vertices = DB::connection()->table("polygons")->where("zone_id", $zone->id)->get(["lat","lng"]);
                $zone->vertices = $vertices;
                // foreach($vertices as &$vertex){
                //     array_push($zone->vertices, array($vertex->lat, $vertex->lng));
                // }
            }

            $this->convertDates($table);
            return $table;
        }catch(\Exception $e){
            return $this->error($e);
        }
    }

    public function comments(){
        try{
            $timestamp = request("timestamp")?? 0;
            $date = date("Y-m-d H:i:s", $timestamp);
            $table = NULL;

            if($location_id = request("location_id")){
                $table = Comment::with('opinion','poster')->where([
                    ["location_id","=",$location_id],
                    ["updated_at",">=",$date]
                ])->paginate($this::PAGE_SIZE);

                foreach($table as &$comment){ // get answer count
                    $comment->answers_count = DB::connection()->table("comments")->where("parent_id", $comment->id)->get(["id"])->count();
                }
            };

            if($comment_id = request("comment_id")){
                $table = Comment::with('opinion','poster')->where([
                    ["parent_id","=",$comment_id],
                    ["updated_at",">=",$date]
                ])->paginate($this::PAGE_SIZE);
            };
            
            if($table == NULL) throw new \Exception("Request error");
            
            return $table->items();
        }catch(\Exception $e){
            return $this->error($e);
        }
    }

    public function messages(){
        return [];
    }

    //------------------------------------------
    // insert new data

    public function storeComment(Request $request){
        try{
            if($this->authenticate() == false) throw new \Exception("Authentication error");

            $validator = Validator::make(request()->all(), [
                'location_id' => "required|numeric",
                'parent_id' => "nullable|numeric",
                'user_id' => 'required|numeric',
                'type' => 'nullable|boolean',
                'text' => 'required|string',
            ]);
            
            if ($validator->fails()) throw new \Exception("Validation error: [" . json_encode($validator->errors()) . "]" );

            $id = DB::table("comments")->insertGetId($validator->validated());
            $result = DB::table("comments")->where("id",$id)->get();
            
            $this->convertDates($result);
            return $result;
        }catch(\Exception $e){
            return $this->error($e);
        }
    }

    public function storeLocation(){
        try{
            if($this->authenticate() == false) throw new \Exception("Authentication error");

            $validator = Validator::make(request()->all(), [
                'name' => "required|string",
                'user_id' => "required|numeric",
                //'zone_id' => "required|numeric",
                'description' => 'nullable|string',
                'address' => 'required|string',
                'lat' => 'required|numeric',
                'lng' => 'required|numeric',
            ]);
            
            if ($validator->fails()) throw new \Exception("Validation error: [" . json_encode($validator->errors()) . "]" );

            $id = DB::table("locations")->insertGetId($validator->validated());
            $result = DB::table("locations")->where("id",$id)->get();
            
            $this->convertDates($result);
            return $result;
        }catch(\Exception $e){
            return $this->error($e);
        }
    }

    public function storeMessage(){
        try{
            if($this->authenticate() == false) throw new \Exception("Authentication error");

            $validator = Validator::make(request()->all(), [
                'user_id' => "required|numeric",
                'location_id' => "required|numeric", // message yra veitoves nusiskundimas? jei vietove yra null - bendras nusiskundimas?
                'title' => "nullable|string",
                'text' => 'required|string',
            ]);
            
            if ($validator->fails()) throw new \Exception("Validation error: [" . json_encode($validator->errors()) . "]" );

            // $id = DB::table("messages")->insertGetId($validator->validated());
            // $result = DB::table("messages")->where("id",$id)->get();
            
            // $this->convertDates($result);
            return []; // $result;
        }catch(\Exception $e){
            return $this->error($e);
        }
    }   

    //------------------------------------------
    // authentication
    
    public function token(){
        return csrf_token();
    }
}
