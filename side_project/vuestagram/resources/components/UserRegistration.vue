<template>
  <div class="form-box">
    <h3 class="form-title">회원가입</h3>
    <input type="text" v-model="registrationInfo.account" name="account" placeholder="아이디">
    <input type="password" v-model="registrationInfo.password" name="password" placeholder="비밀번호" autoComplete="off">
    <input type="password" v-model="registrationInfo.password_chk" name="password_chk" placeholder="비밀번호 확인" autoComplete="off">
    <input type="text" v-model="registrationInfo.name" name="name" placeholder="이름" autoComplete="off">
    <div class="radio-box">
      <div>
        <label for="male">남자</label>
        <input type="radio" v-model="registrationInfo.gender" name="name" id="male" value="0">
      </div>
      <div>
        <label for="female">여자</label>
        <input type="radio" v-model="registrationInfo.gender" name="name" id="female" value="1">
      </div>
    </div>
    <input @change="setFile" type="file" name="profile" accept="image/*">
    <hr>
    <button @click="store.dispatch('registration', registrationInfo)" class="btn btn-submit btn-bg-black">로그인</button>
    <button @click="$router.back()" class="btn btn-submit">취소</button>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const registrationInfo = reactive({
  account: '',
  password: '',
  password_chk: '',
  name: '',
  gender: '',
  profile: '',
});

function setFile(e) {
  registrationInfo.profile = e.target.files[0];
}
</script>

<style>
</style>
