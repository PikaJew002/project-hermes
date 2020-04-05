<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Parse query string to extract options.
     *
     * @return array
     */
    public function parseOptions(Request $request) {
        $query = $request->query();
        $options = [
            'with' => []
        ];
        if(isset($query['query'])) {
            $options['with'] = explode(':', $query['with']);
        }

        return $options;
    }
}
