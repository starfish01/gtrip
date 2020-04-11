<?php

namespace App\Http\Controllers;

use App\searchKeys;
use Illuminate\Http\Request;

class searchKeysController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\searchKeys  $searchKeys
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data = request()->validate([
            'item' => 'required',
            'type' => 'required'
        ]);

        $column = 'keys';
        if ($data['type'] === 'skip') {
            $column = 'skip_keys';
        }


        $arrayToUpdate = searchKeys::where([
            ['user_id', auth()->user()->id],
            ['destination_details_id', $id]
        ])->select($column)->get()[0][$column];

        $arrayToUpdate = preg_replace("/(\[)|(\])/", "", $arrayToUpdate);
        $arrayToUpdate = explode(",", $arrayToUpdate);
        $pos = array_search($data['item'], $arrayToUpdate);
        unset($arrayToUpdate[$pos]);
        
        $arrayToUpdate = implode(",",$arrayToUpdate);

        searchKeys::where([
            ['user_id', auth()->user()->id],
            ['destination_details_id', $id]
        ])->update([$column => $arrayToUpdate]);

        return $arrayToUpdate;
        
    }

    public function addKey(Request $request, $id)
    {
       
        $data = request()->validate([
            'key' => 'required',
            'type' => 'required'
        ]);

        $column = 'keys';
        if ($data['type'] === 'skip') {
            $column = 'skip_keys';
        }

        $arrayToUpdate = searchKeys::where([
            ['user_id', auth()->user()->id],
            ['destination_details_id', $id]
        ])->select($column)->get()[0][$column];

        if (!empty($arrayToUpdate)) {
            $arrayToUpdate .= ',' . $data['key'];
        } else {
            $arrayToUpdate = $data['key'];
        }

        searchKeys::where([
            ['user_id', auth()->user()->id],
            ['destination_details_id', $id]
        ])->update([$column => $arrayToUpdate]);

        return $arrayToUpdate;

    }
}
