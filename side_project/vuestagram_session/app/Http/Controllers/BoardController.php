<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    // 최초 게시글 획득
    public function index() {
        $boardData = Board::select('boards.*', 'users.name')
                            ->join('users', 'users.id', '=', 'boards.user_id')
                            ->orderBy('id', 'DESC')
                            ->limit(20)
                            ->get();
        
        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $boardData->toArray()
        ];

        return response()->json($responseData, 200);
    }
    
    // 추가 게시글 획득
    public function moreIndex($id) {
        $boardData = Board::select('boards.*', 'users.name')
                            ->join('users', 'boards.user_id', '=', 'users.id')
                            ->where('boards.id', '<', $id)
                            ->orderBy('boards.id', 'DESC')
                            ->limit(20)
                            ->get();

        $responseData = [
            'code' => '0'
            ,'msg' => '추가 게시글 획득 완료'
            ,'data' => $boardData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 게시글 작성
    public function store(Request $request) {
        // 유효성 검사
        $validator = Validator::make(
            $request->only('content', 'img')
            ,[
                'content' => ['required', 'min:1', 'max:200']
                ,'img' => ['required', 'image']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        // 이미지 파일 저장
        $path = $request->file('img')->store('img');

        // 인서트 처리
        $boardModel = Board::select('boards.*', 'users.name')
                                ->join('users', 'users.id', '=', 'boards.id')
                                ->where('users.id', Auth::id())
                                ->first();

        $boardModel->content = $request->content;
        $boardModel->img = $path;
        $boardModel->user_id = Auth::id();
        $boardModel->save();

        // 레스폰스 처리
        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $boardModel->toArray()
        ];

        return response()->json($responseData, 200);
    }
}
