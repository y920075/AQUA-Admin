<script>
//建立分頁標籤
function pageBar(page){
	//先清空td的內容，避免重疊
	$('td#pagebar').empty()
	//宣告變數方便之後使用
	let i,numPerPage,totalPage;
	//每頁要顯示多少資料
	numPerPage = 10;
	//將取得的page值除以要顯示的總數，然後無條件進位
	totalPage = Math.ceil(page/numPerPage)
	//透過for迴圈印出分頁按鈕
	for( i = 1; i <= totalPage; i++){
		//onclick設定this 把button自己當成參數傳送給函式，以利後續函式取值使用
		$('td#pagebar').append(`<button  class="page-btn" onclick="pageChange(this)" value="${i}">${i}</button>`)
	}
}

//取得分頁資料，這裡參數使用分頁按鈕點擊事件取得的頁碼
//將取得的頁碼一起傳送到後端作為LIMIT條件用
function getPageData(page){
    //給關鍵字預設值，如果點擊分頁按鈕時有值存在就給值，否則給null，讓後端php程式判斷要用什麼條件搜索
    let keyword_ajax = $('#search_keyword').val() ? $('#search_keyword').val() : 'null';
    $.ajax({
        //選擇要接收AJAX資料的php檔案
        url: "search_page.php", 
        //要傳送的過去的資料
        data: {	'search_type' : $('#search_type').val(),
				'search_date' : $('#search_date').val(),
                'keyword' : keyword_ajax,
				'page' : page,
		},
        //傳送的方式 
        type:'POST', 
        //傳送的資料格式
        dataType:'json', 

        //如果執行成功就執行success函式 引數data就是PHP傳送回來的資料
        success: function(data){
            console.log(data);

			$('tbody#class_data_body').empty()
            //取得JSON字串長度
            let jsonlength = data.length; 
            //宣告變數以便迴圈中使用
            let eventId,eventName,eventTypeName,LocationName,eventSponsor,eventStartDate,eventEndDate,created_at,updated_at;
            //執行迴圈依照JSON長度新增選項
            for (  i = 0 ; i < jsonlength ; i++) {
                eventId = data[i]['eventId'];
                eventName = data[i]['eventName'];
				eventTypeName = data[i]['eventTypeName'];
				if ( data[i]['LocationName'] == null ) {
					LocationName = data[i]['eventLocal'];
				} else {
					LocationName = data[i]['LocationName'];
				}
				eventSponsor = data[i]['eventSponsor'];
				eventStartDate = data[i]['eventStartDate'];
				eventEndDate = data[i]['eventEndDate'];
				created_at = data[i]['created_at'];
				updated_at = data[i]['updated_at'];
                //動態新增選項
				$('tbody#class_data_body').append(`<tr id="class_Data${i}"></tr>`);
                $(`tr#class_Data${i}`).append(`<td>${eventId}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventName}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventTypeName}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${LocationName}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventSponsor}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventStartDate}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventEndDate}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${created_at}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${updated_at}</td>`);
                $(`tr#class_Data${i}`).append(`<td>
												<a class="btn btn-primary" href="./edit_event.php?editeventId=${eventId}">查看</a>
												<a class="btn btn-secondary" href="./delete_event.php?deleteeventId==${eventId} onclick="return confirm('確認是否要刪除?')">刪除</a>
											  </td> `);

            };
        }
    });
}

//Chrome可到Network查詢收到了什麼檔案，在點選檔案裡的preview確認收到什麼值

// 分頁按鈕點擊事件，按下分頁按鈕之後會將value頁碼傳送給getPageData函式作為參數使用
function pageChange(button){ 
		//debug用 要查詢傳進來的物件是什麼時，
        //就把它指定給window底下的一個屬性，在到console中確認
        //名稱"testvalue"可以自行設定
		window.testvalue = button;
		//取得按鈕中的值，用以表示現在的頁數
　　　　let nowPage = button.value; 
		//呼叫函式取得資料
	　　getPageData(nowPage); 
}

//取得類型與日期的篩選資料
function type(){
    $.ajax({
        //選擇要接收AJAX資料的php檔案
        url: "search_type.php", 
        //要傳送的過去的資料
        data: {	'search_type' : $('#search_type').val(),
				'search_date' : $('#search_date').val(),
                'page' : 1,
		},
        //傳送的方式 
        type:'POST', 
        //傳送的資料格式
        dataType:'json', 

        //如果執行成功就執行success函式 引數data就是PHP傳送回來的資料
        success: function(data){
			$('tbody#class_data_body').empty();
			let totalPage = data.pop(); //取出JSON陣列中的最後一個值
			pageBar(totalPage); //將該值作為總筆數參數，呼叫函式建立分頁按鈕
            //取得JSON字串長度
            let jsonlength = data.length; 
            //宣告變數以便迴圈中使用
            let eventId,eventName,eventTypeName,LocationName,eventSponsor,eventStartDate,eventEndDate,created_at,updated_at;
            //執行迴圈依照JSON長度新增選項
            for (  i = 0 ; i < jsonlength ; i++) {
                eventId = data[i]['eventId'];
                eventName = data[i]['eventName'];
				eventTypeName = data[i]['eventTypeName'];
				if ( data[i]['LocationName'] == null ) {
					LocationName = data[i]['eventLocal'];
				} else {
					LocationName = data[i]['LocationName'];
				}
				eventSponsor = data[i]['eventSponsor'];
				eventStartDate = data[i]['eventStartDate'];
				eventEndDate = data[i]['eventEndDate'];
				created_at = data[i]['created_at'];
				updated_at = data[i]['updated_at'];
                //動態新增選項
				$('tbody#class_data_body').append(`<tr id="class_Data${i}"></tr>`);
                $(`tr#class_Data${i}`).append(`<td>${eventId}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventName}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventTypeName}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${LocationName}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventSponsor}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventStartDate}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventEndDate}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${created_at}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${updated_at}</td>`);
                $(`tr#class_Data${i}`).append(`<td>
												<a class="btn btn-primary" href="./edit_event.php?editeventId=${eventId}">查看</a>
												<a class="btn btn-secondary" href="./delete_event.php?deleteeventId==${eventId} onclick="return confirm('確認是否要刪除?')">刪除</a>
											  </td> `);
            };
        }
    });
}

//偵測篩選類別的狀態
$("select#search_type").change(type);

//偵測篩選時間的狀態
$("select#search_date").change(type);

//偵測搜索關鍵字的點擊事件
$('button#search_btn').on('click',function(){
	$.ajax({
		url: "search_keyword.php", 
		data: {	
			search_type : $('#search_type').val(),
			search_date : $('#search_date').val(),
			keyword : $('#search_keyword').val(),
            page : 1,
			},
		type:'POST',
        dataType:'json', 

        //如果執行成功就執行success函式 引數data就是PHP傳送回來的資料
        success: function(data){
			$('tbody#class_data_body').empty();
            let totalPage = data.pop(); //取出JSON陣列中的最後一個值
			pageBar(totalPage); //將該值作為總筆數參數，呼叫函式建立分頁按鈕
            //取得JSON字串長度
            let jsonlength = data.length; 
            //宣告變數以便迴圈中使用
			let eventId,eventName,eventTypeName,LocationName,eventSponsor,eventStartDate,eventEndDate,created_at,updated_at;
            //執行迴圈依照JSON長度新增選項
            for (  i = 0 ; i < jsonlength ; i++) {
                eventId = data[i]['eventId'];
                eventName = data[i]['eventName'];
				eventTypeName = data[i]['eventTypeName'];
				if ( data[i]['LocationName'] == null ) {
					LocationName = data[i]['eventLocal'];
				} else {
					LocationName = data[i]['LocationName'];
				}
				eventSponsor = data[i]['eventSponsor'];
				eventStartDate = data[i]['eventStartDate'];
				eventEndDate = data[i]['eventEndDate'];
				created_at = data[i]['created_at'];
				updated_at = data[i]['updated_at'];
                //動態新增選項
				$('tbody#class_data_body').append(`<tr id="class_Data${i}"></tr>`);
                $(`tr#class_Data${i}`).append(`<td>${eventId}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventName}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventTypeName}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${LocationName}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventSponsor}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventStartDate}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${eventEndDate}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${created_at}</td>`);
                $(`tr#class_Data${i}`).append(`<td>${updated_at}</td>`);
                $(`tr#class_Data${i}`).append(`<td>
												<a class="btn btn-primary" href="./edit_event.php?editeventId=${eventId}">查看</a>
												<a class="btn btn-secondary" href="./delete_event.php?deleteeventId==${eventId} onclick="return confirm('確認是否要刪除?')">刪除</a>
											  </td> `);

            };
        }
	})
})

</script>