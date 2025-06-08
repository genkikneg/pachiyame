$(function(){
    fetch('https://misoon.net/pachiyame/backend/api/get_user.php', {
        credentials: 'include',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
    })
        .then(res => res.json())
        .then(function(data){
            console.log(data);
            if(data.msg === false){
                window.location.replace('/pachiyame/frontend/login.html');
            }
        })
        .catch(err => {
            console.log(err);
        }
    );

    //記事を投稿
    //articlesAPIにPOST
    $('#post-btn').click(async function(){
        const body = $('#post-body').val();
        const tag = $('#post-tag').val();

        const isPUT = $(this).data('isPUT');
        const article_id = $(this).data('id');

        const method = isPUT ? 'PUT' : 'POST'
        //API呼び出し
        fetch('https://misoon.net/pachiyame/backend/api/articles.php', {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                body: body,
                tag: tag,
                article_id: article_id
            })
        })
            .then(res => res.json())
            .then(async function(data){
                console.log(data);
                
                await articles_get();
            });
        });

    //記事を編集
    //articlesAPIにPUT
    $(document).on('click','.edit-btn' , function(){
        const modal = new bootstrap.Modal($('#post-modal').get(0));
        //モーダルを開く
        modal.show();
        const card = $(this).closest('.card');
        const body =  card.find('.card-body > .card-text').text();
        const tag = card.find('.card-footer > p').text();
        const id = card.find('.card-footer > input[type=hidden]').val();
        

        $('#post-body').val(body);
        $('#post-tag').val(tag);

        $('#post-btn').data('isPUT', 1);
        $('#post-btn').data('id', id);
    });

    //記事を削除
    //articlesAPIにDELETE
    $(document).on('click', '.remove-btn', function(){
        const card = $(this).closest('.card');
        const articles_id = card.find('.card-footer > input[type=hidden]').val();

        //API呼び出し
        fetch('https://misoon.net/pachiyame/backend/api/articles.php',{
            method: 'DELETE',
            headers:{
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                article_id: articles_id
            })
        })
            .then(res => res.json())
            .then(async function(data){
                console.log(data);

                await articles_get();
            })
    })
})

//articlesAPIにGET
function articles_get(){
    //API呼び出し
    fetch('https://misoon.net/pachiyame/backend/api/articles.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(res => res.json())
        .then(function(data){
            $('.posts-item').html('');
            data.forEach(data2 => {
                $('.posts-item').append(
                    `
                    <div class="p-2 row justify-content-center">
                        <div class="item card w-50">
                            <div class="card-body">
                                <p class="card-text">${data2.body}</p>
                                <div class="card-footer row">
                                    <p> ${data2.tag}</p>
                                    <input type=hidden value="${data2.id}">
                                    <button type="button" class="btn btn-outline-success col-2 edit-btn">編集</button>
                                    <a href="#" class="btn btn-outline-danger col-2 remove-btn">削除</a>
                                    <span class="text-end col-8">
                                        ${data2.insert_datetime}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    `);
            });
        })
}
articles_get();

