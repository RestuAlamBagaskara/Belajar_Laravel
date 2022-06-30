<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{
    public function response(Request $request): Response
    {
        return response("hello response");
    }

    public function header(Request $request): Response
    {
        $body = [
            'firstName' => 'Alam',
            'lastName' => 'Bagas'
        ];

        return response(json_encode($body), 200)
            ->header('Content-Type', 'application/json')
            ->withHeaders([
                'Author' => 'Programmer Zaman Now',
                'App' => 'Belajar Laravel'
            ]);
    }

    //mengembalikan response dalam bentuk view
    public function responseView(Request $request): Response
    {
        return response()
            ->view('hello', ['name' => 'Alam']);
    }

    //mengembalikan response dalam bentuk json
    public function responseJson(Request $request): JsonResponse
    {
        $body = [
            'firstName' => 'Alam',
            'lastName' => 'Bagas'
        ];
        return response()
            ->json($body);
    }

    //mengembalikan response dalam bentuk file
    public function responseFile(Request $request): BinaryFileResponse
    {
        return response()
            ->file(storage_path('app/public/pictures/Batu.png'));
    }

    //mengembalikan response dalam bentuk file yang di dwonload
    public function responseDownload(Request $request): BinaryFileResponse
    {
        return response()
            ->download(storage_path('app/public/pictures/Batu.png'));
    }
}
