// Math 객체

// 올림, 반올림, 버림
Math.ceil(0.1); // 1
Math.round(0.5); // 1
Math.floor(0.9); // 0

// 랜덤값
Math.random(); // 0 ~ 1 랜덤한 수를 반환
// 1~10 랜덤 숫자 획득
Math.ceil(Math.random() * 10);

// for(let i = 0; i < 1000000; i++) {
//     test[test.length] = Math.ceil(Math.random() * 10);
// }

// 최대값
const ARR = [6,3,4,65,87,8,3,2];
let max = Math.max(...ARR);
console.log(max);

// 최소값
let min = Math.min(...ARR);
console.log(min);

// 절대값
Math.abs(1);
Math.abs(-1);