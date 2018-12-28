<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use Illuminate\Http\Request;

class UploadsController extends Controller
{
    //
    public function fileUpload( ImageRequest $request )
    {


        $strategy = $request->get( 'strategy', 'images' );
        if ( !$request->hasFile( 'file' ) ) {
            return response()->json( [
                'success' => false,
                'error'   => 'no file found.',
            ] );
        }
        $file     = $request->file( 'file' );
        $filename = str_random().".".$file->getClientOriginalExtension();
        $path = '/uploads/'. $strategy.'/'.date( 'Y' ).'/'.date( 'm' ).'/'.date( 'd' );
        $file->move(public_path($path), $filename);
        return response()->json($path .'/'.$filename);
    }
}
