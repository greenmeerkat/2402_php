import { createStore } from 'vuex';
import axios from './axios';
import router from './router';

const store = createStore({
    state() {
        return {
            authFlg: localStorage.getItem('accessToken') ? true : false,
            userInfo: localStorage.getItem('userInfo') ? JSON.parse(localStorage.getItem('userInfo')) : {},
            boardList: [],
            lastID: localStorage.getItem('lastID') ? localStorage.getItem('lastID') : 0,
            noMoreBoardListFlg: false,
        }
    },
    mutations: {
        // ----------
        // 인증관련
        // ----------
        setAuthFlg(state, boo) {
            state.authFlg = boo;
        },
        // -------------
        // 유저 정보 관련
        // -------------
        setUserInfo(state, userInfo) {
            state.userInfo = userInfo;
        },
        setUserBoardsCount(state) {
            state.userInfo.boards_count++;
        },
        // -------------
        // 게시글 관련
        // -------------
        setNoMoreBoardListFlg(state, flg) {
            state.noMoreBoardListFlg = flg;
        },
        setBoardList(state, data) {
            state.boardList = data;
        },
        setLastID(state, id) {
            state.lastID = id;
        },
        setConcatBoardList(state, data) {
            state.boardList = state.boardList.concat(data);
        },
        setUnshiftBoardList(state, data) {
            state.boardList.unshift(data);
        },
    },
    actions: {
        // ----------
        // 인증관련
        // ----------
        /**
         * 로그인
         * 
         * @param {*} context 
         * @param {*} userInfo 
         */
        login(context, userInfo) {
            const url = '/api/login';
            axios.post(url, JSON.stringify(userInfo))
            .then(response => {
                localStorage.setItem('accessToken', response.data.accessToken);
                localStorage.setItem('refreshToken', response.data.refreshToken);
                localStorage.setItem('userInfo', JSON.stringify(response.data.data));

                // state 갱신
                context.commit('setAuthFlg', true);
                context.commit('setUserInfo', response.data.data);
                router.replace('/board');
            })
            .catch(error => {
                console.log(error.response);
                const errorCode = error.response.data.code ? error.response.data.code : 'FE99';
                alert('로그인 실패 : ' + errorCode);
            })
        },
        /**
         * 로그아웃 처리
         *  
         * @param {*} context 
         */
        logout(context) {
            // 토큰 유효성 체크 후, 처리 속행
            context.dispatch('chkTokenAndContinueProcess', () => {
                const url = '/api/logout';
                const config = {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                    }
                }
                axios.post(url, null, config)
                .then(response => {
                    alert('로그아웃 완료');
                })
                .catch(error => {
                    console.log(error);
                    console.log(error.response);
                    alert('문제가 생겨 로그아웃 처리');
                })
                .finally(() => {
                    // 로컬 스토리지 비우기
                    localStorage.clear();
    
                    // store state 초기화
                    context.commit('setAuthFlg', false);
                    context.commit('setUserInfo', {});
                    // context.commit('setLastID', 0);
    
                    // 로그인으로 이동
                    router.replace('/login');
                });
            });
        },
        // 회원가입
        registration(context, registrationInfo) {
            const url = '/api/registration';
            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            };

            // 데이터 셋팅
            const data = new FormData();
            data.append('account', registrationInfo.account);
            data.append('password', registrationInfo.password);
            data.append('password_chk', registrationInfo.password_chk);
            data.append('name', registrationInfo.name);
            data.append('gender', registrationInfo.gender);
            data.append('profile', registrationInfo.profile);

            // ajax 처리
            axios.post(url, data, config)
            .then(response => {
                router.replace('/login');
            })
            .catch(error => {
                console.error(error.response);
                alert('회원가입 실패!(' + error.response.data.code + ')');
            });
        },
        /**
         * 보드 리스트 정보 획득
         * 
         * @param {*} context 
         */
        getBoardList(context) {
            // 토큰 유효성 체크 후, 처리 속행
            context.dispatch('chkTokenAndContinueProcess', () => {
                const url = '/api/board/' + context.state.lastID + '/list';
                const config = {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                    }
                }
    
                axios.get(url, config)
                .then(response => {
                    const data = response.data.data;
                    context.commit('setBoardList', data);
    
                    const id = data[data.length - 1].id;
                    localStorage.setItem('lastID', id);
                    context.commit('setLastID', id);
                })
                .catch(error => {
                    console.log(error);
                    console.log(error.response);
                    const code = error.response ? error.response.data.code : '';
                    alert('게시글 습득에 실패했습니다.(' + code + ')');
                });
            });
        },
        /**
         * 추가 게시글 리스트 획득
         * 
         * @param {*} context 
         */
        getAddBoardList(context) {
            // 토큰 유효성 체크 후, 처리 속행
            context.dispatch('chkTokenAndContinueProcess', () => {
                const url = '/api/board/' + context.state.lastID;
                const config = {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                    }
                }
                
                // axios 처리
                axios.get(url, config)
                .then(response => {
                    const data = response.data.data;
                    if(data.length > 0 ) {
                        // 게시글 정보가 있을 때 처리
                        context.commit('setConcatBoardList', data); // 추가 게시글 저장
    
                        // 마지막 게시글 id 저장
                        context.commit('setLastID', data[data.length - 1].id); 
                        localStorage.setItem('lastID', data[data.length - 1].id);
                    } else {
                        // 게시글 정보가 없을 때 처리
                        // 더이상 게시글이 없기 때문에 서버에 요청을 하지않기 위한 플래그 true로 셋팅
                        context.commit('setNoMoreBoardListFlg', true);
    
                        // 마지막 게시글 아이디 제거
                        context.commit('setLastID', 0);
                        localStorage.removeItem('lastID');
                    }
                    // console.log('추가 게시글 획득 완료');
                })
                .catch(error => {
                    console.log(error);
                    console.log(error.response);
                    const code = error.response ? error.response.data.code : '';
                    alert('게시글 습득에 실패했습니다.(' + code + ')');
                });
            });
        },
        /**
         * 게시글 작성
         * 
         * @param {store} context 
         * @param {object} boardInfo 
         */
        storeBoard(context, boardInfo) {
            // 토큰 유효성 체크 후, 처리 속행
            context.dispatch('chkTokenAndContinueProcess', () => {
                // 게시글 작성 ajax처리
                const url = '/api/board';
                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                    }
                }
                const data = new FormData();
                data.append('content', boardInfo.content);
                data.append('img', boardInfo.img);
    
                // axios 처리
                axios.post(url, data, config)
                .then(response => {
                    if(context.state.boardList.length > 1) {
                        // 보드리스트의 가장 앞에 작성한 글 정보 추가
                        context.commit('setUnshiftBoardList', response.data.data);
                    }
    
                    // 유저의 작성글 수 1 증가
                    context.commit('setUserBoardsCount');
                    localStorage.setItem('userInfo', JSON.stringify(context.state.userInfo));
    
                    // 게시글 인덱스로 이동
                    router.replace('/board');
                })
                .catch(error => {
                    // console.log(error);
                    // console.log(error.response);
                    const code = error.response ? error.response.data.code : '';
                    alert('게시글 작성에 실패했습니다.(' + code + ')');
                });
            });
        },
        /**
         * 토큰 유효성 체크 후, 처리 속행
         *
         * @param {Object} context
         * @param {function} callbackProcess
         */
        chkTokenAndContinueProcess(context, callbackProcess) {
            // 토큰 만료
            if(store.dispatch('chkExpiredToken')) {
                console.log('만료');
                store.dispatch('reissueAccessToken', callbackProcess);
            } else {
                console.log('유효');
                // 토큰 유효
                callbackProcess();
            }
        },
        /**
         * 토큰 만료 체크
         *
         * @returns boolean true||false
         */
        chkExpiredToken() {
            // Payload 획득
            const payload = localStorage.getItem('accessToken').split('.')[1];
            const base64 = payload.replace(/-/g, '+').replace(/_/g, '/');
            const objPayload = JSON.parse(window.atob(base64));
    
            // 토큰 만료 획득
            const ext = objPayload.ext + '000';
    
            // 현재 시간 획득
            const now = new Date();
    
            // 만료 체크 결과 리턴
            return ext < now.getTime();
        },
        /**
         * 토큰 재발급 처리
         * 
         * @param {store} context 
         * @param {callback} callbackProcess 
         */
        async reissueAccessToken(context, callbackProcess) {
            console.log('토큰 재발급');
            try {
                const url = '/api/reissue';
                const config = {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('refreshToken')
                    }
                };
    
                // 토큰 재발급
                const response = await axios.post(url, null, config);
    
                // 토큰 셋팅
                localStorage.setItem('accessToken', response.data.accessToken);
                localStorage.setItem('refreshToken', response.data.refreshToken);
                console.log('토큰 셋팅 완료');
                // 후속 처리 진행
                callbackProcess();
            } catch (error) {
                console.error(error);
                const code = error.response ? error.response.data.code : 'E99';
                const msg = error.response ? error.response.data.msg : '오류가 발생했습니다.\n오류가 지속될 경우 로그아웃 후 다시 시도해 주세요.';
                alert(code + ' : ' + msg);
            }
    
        }
    },
});

export default store;