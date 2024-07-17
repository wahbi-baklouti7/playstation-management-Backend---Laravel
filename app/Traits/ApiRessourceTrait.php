<?php



namespace App\Traits;

trait ApiRessourceTrait{




    public function successMessage($msg, $code = 200)
    {
        return response()->json([

            'status' => true,
            'message' => $msg,
        ], $code);

    }


    public function errorMessage($msg, $code = 404)
    {
        return response()->json([
            'status' => false,
            'message' => $msg,
        ], $code);
    }

    public function returnData($data, $msg=null, $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $msg,
            'data' => $data
        ], $code);
    }
}
