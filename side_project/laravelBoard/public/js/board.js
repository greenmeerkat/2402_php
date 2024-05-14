// 상세 모달 처리
document.querySelectorAll(".my-btn-detail").forEach(item => {
    item.addEventListener('click', () => {
        const url = '/board/' + item.value;
        
        axios.get(url)
        .then(response => {
            const data = response.data;

            const btnDelete = document.querySelector('#my-btn-delete'); // 삭제 버튼
            const modalTitle = document.querySelector('.modal-title'); // 제목 노드
            const modalContent = document.querySelector('.modal-body > p'); // 내용 노드
            const modalImg = document.querySelector('.modal-body > img'); // 이미지 노드

            // 상세 정보 셋팅
            modalTitle.textContent = data.title;
            modalContent.textContent = data.content;
            modalImg.src = data.img;

            // 삭제 버튼 셋팅
            if(data.auth_id !== data.user_id) {
                btnDelete.classList.add('d-none');
                btnDelete.value = '';
            } else {
                btnDelete.classList.remove('d-none');
                btnDelete.value = data.id;
            }
        })
        .catch(err => console.log(err));
    });
});

// 삭제 처리
document.querySelector('#my-btn-delete').addEventListener('click', MyDeleteCard);

function MyDeleteCard(e) {
    const url = '/board/' + e.target.value; // url
    
    // Ajax 처리
    axios.delete(url)
    .then(response => {
        if(response.data.errorFlg) {
            // 삭제 이상 발생
            alert('삭제에 실패 했습니다.');
        } else {
            // 정상처리
            const main = document.querySelector('main');
            const card = document.querySelector('#card' + response.data.deletedId);
            main.removeChild(card);
        }
    })
    .catch();
}