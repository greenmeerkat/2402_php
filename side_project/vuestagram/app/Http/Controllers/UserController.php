<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAuthException;
use App\Exceptions\MyValidateException;
use App\Models\User;
use MyUserValidate;
use MyToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * 로그인 처리
     */
    public function login(Request $requset) {
        Log::debug('Start Login', $requset->all());

        $requsetData = [
            'account' => $requset->account
            ,'password' => $requset->password
        ];
        
        // 유효성 검사
        $resultValidate = MyUserValidate::myValidate($requsetData);

        // 유효성 검사 실패 처리
        if($resultValidate->fails()) {
            Log::debug('login Valridation Error', $resultValidate->errors()->all());
            throw new MyValidateException('E01');
        }

        // 유저 정보 조회
        $resultUserInfo = User::where('account', $requset->account)
                                ->withCount('boards')
                                ->first();

        // 미등록 유저 체크
        if(!isset($resultUserInfo)) {
            throw new MyAuthException('E20');
        }

        // 패스워드 체크
        if(!(Hash::check($requset->password, $resultUserInfo->password))) {
            throw new MyAuthException('E21');
        }

        // 토큰 발행
        list($accessToken, $refreshToken) = MyToken::createTokens($resultUserInfo);

        // 리프래시 토큰 저장
        MyToken::updateRefreshToken($resultUserInfo, $refreshToken);

        // response Data
        $responseData = [
            'code' => '0'
            ,'msg' => '인증 완료'
            ,'accessToken' => $accessToken
            ,'refreshToken' => $refreshToken
            ,'data' => $resultUserInfo
        ];
        return response()->json($responseData, 200);
    }

    /**
     * 로그아웃
     * 
     * @param   Illuminate\Http\Request $request
     * 
     * @return  response() json
     */
    public function logout(Request $request) {
        $id = MyToken::getValueInPayload($request->bearerToken(), 'idt');

        $userInfo = User::find($id);

        MyToken::removeRefreshToken($userInfo);

        $responseData = [
            'code' => '0'
            ,'msg' => ''
            ,'data' => $userInfo
        ];

        return response()->json($responseData, 200);
    }

    /**
     * 회원가입 처리
     * 
     * @param   Illuminate\Http\Request $request
     * 
     * @return  response() json
     */
    public function registration(Request $request) {
        // 리퀘스트 데이터 가공
        $requestData = [
            'account' => $request->account
            ,'password' => $request->password
            ,'password_chk' => $request->password_chk
            ,'name' => $request->name
            ,'gender' => $request->gender
        ];
        if($request->has('profile')) {
            $requestData['profile'] = $request->profile;
        }

        // 유효성 검사
        $validator = MyUserValidate::myValidate($requestData);

        // 유효성 검사 실패시 처리
        if($validator->fails()){
            Log::debug('유효성 검사 실패 : ', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        // ID 중복 체크
        if(!empty(User::where('account', $request->account)->first())) {
            throw new MyValidateException('E02');
        }

        // 프로필이 있을 경우 유저가 전달한 프로필 설정, 프로필이 없을 경우 기본 프로필 설정
        if($request->has('profile')) {
            $requestData['profile'] = "/".$request->file('profile')->store('profile');
        } else {
            $requestData['profile'] = '/profile/default.png';
        }

        // 비밀번호 hash
        $requestData['password'] = Hash::make($request->password);

        // 유저 Insert
        $userInfo = User::create($requestData);

        // Response 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '가입 완료'
            ,'responseData' => $userInfo
        ];
        return response()->json($responseData, 200);
    }

    /**
     * 토큰 재발급
     * 
     * @param   Illuminate\Http\Request $request
     * 
     * @return  response() json
     */
    public function reissue(Request $request) {
        Log::debug('********************** 토큰 재발급 시작 **********************');
        // 유저 PK 획득
        $id = MyToken::getValueInPayload($request->bearerToken(), 'idt');
        Log::debug('베어럴 토큰 : '.$request->bearerToken());
        Log::debug('유저 PK : '.$id);

        // 유저 정보 획득
        $resultUserInfo = User::find($id);
        Log::debug('유저 정보 : ', $resultUserInfo->toArray());

        // 유효한 유저 확인
        if(!isset($resultUserInfo)) {
            throw new MyAuthException('E20');
        }
        Log::debug('유효한 유저 확인 완료');

        // 리프래시 토큰 체크
        if($request->bearerToken() !== $resultUserInfo->refresh_token) {
            throw new MyAuthException('E23');
        }
        Log::debug('리프래시 토큰 체크 완료');
        
        // 토큰 발행
        list($accessToken, $refreshToken) = MyToken::createTokens($resultUserInfo);
        Log::debug('토큰 발행 완료');

        // 리프래시 토큰 저장
        MyToken::updateRefreshToken($resultUserInfo, $refreshToken);
        Log::debug('토큰 저장 완료');

        // response Data
        $responseData = [
            'code' => '0'
            ,'msg' => '인증 완료'
            ,'accessToken' => $accessToken
            ,'refreshToken' => $refreshToken
            ,'data' => $resultUserInfo
        ];

        Log::debug('********************** 토큰 재발급 완료 **********************');
        return response()->json($responseData, 200);
    }
}
