<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.4.0/paper/bootstrap.min.css" rel="stylesheet">
	<script src="jquery-1.12.4.min.js"></script>
	<link href="filter.css" rel="stylesheet">
	<title>JS SORT Table</title>
	<style>
        body {
            background-color: #f7f7f7;
        }
	</style>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="panel panel-primary filterable">
			<div class="panel-heading">
				<h3 class="panel-title">
					<button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span>
					</button>
				</h3>
			
			</div>
			<table class="table table-bordered table-striped">
				<thead>
				<tr class="filters">
					<th>
						<div class="sort_filter"><input type="text" class="tablehead form-control" data-sort="false"
														data-column="rank"
														data-order="desc"
														placeholder="#" disabled></div>
					</th>
					<th>
						<div class="sort_filter"><input type="text" class="tablehead form-control" data-sort="true"
														data-order="desc"
														data-column="first_name" placeholder="First Name ►" disabled>
						</div>
					</th>
					<th>
						<div class="sort_filter"><input type="text" class="tablehead form-control" data-sort="true"
														data-order="desc"
														data-column="last_name" placeholder="Last Name ►" disabled>
						</div>
					</th>
					<th>
						<div class="sort_filter"><input type="text" class="tablehead form-control" data-sort="true"
														data-order="desc"
														data-column="user_name" placeholder="Username ►" disabled>
						</div>
					</th>
				</tr>
				</thead>
				<tbody id="table-body">
				
				</tbody>
			</table>
			<div id="pagination">
				<br>
				<div id="pagination-wrapper"></div>
				<br>
			</div>
		</div>
	</div>
</div>
<style>
    .btn_pagination {
        background: #2196f3;
        color: white;
    }

    #pagination {
        text-align: center;
    }
</style>
<script>
	
    var sort = {'first_name': 'desc', 'rank': 'desc', 'last_name': 'desc','user_name':'desc'}

    var tableData =
        [{
            'first_name': 'aussell',
            'last_name': 'milson',
            'user_name': 'mike',
            'rank': '1',
        }]

    var alpha = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h']
    for (var i = 0; i < 50;i++) {

        let firstname = '';
        let lastname = '';
        let username = '';
        let rank = '';
        for (var t = 0; t < 3; t++) {
            let ind = Math.floor(Math.random() * 3)
            firstname += alpha[ind];
        }
        for (var t = 0; t < 3; t++) {
            let ind = Math.floor(Math.random() * 3)
            lastname += alpha[ind];
        } for (var t = 0; t < 3; t++) {
            let ind = Math.floor(Math.random() * 3)
            username += alpha[ind];
        }for (var t = 0; t < 3; t++) {
            let ind = Math.floor(Math.random() * 3)
            rank += ind;
        }
        arr = {
            'first_name': firstname,
            'last_name': lastname,
			'user_name':username,
            'rank': rank,
        }
        tableData.push(arr);

    }

    var copytable;
    var icons = ["▼", "▲", "►"]
    var sortarr = []
	var filterarr = []

    $(".btn-filter").click(function () {
        var t = $(this).parents(".filterable")
        e = t.find(".filters input")
		if(1 == e.prop("disabled")){
            e.prop("disabled", !1)
			e.each(function (index){
				let column = $(e[index]).data('column')
                for (var key in filterarr){
                    if(key ==column ){
                        $(e[index]).val(filterarr[key])
                	}
                }
			})
            e.first().focus()
		}else{
            e.val("").prop("disabled", !0)
			
		}
        // 1 == e.prop("disabled") ? (e.prop("disabled", !1), e.first().focus()) : (e.val("").prop("disabled", !0), l.find("tr").show())
    });

    $("th > .sort_filter").click(function (evt) {
        var input_el = $(this).children()[0];
        if ($(input_el).prop("disabled")) {
            var column = $(input_el).data('column')
            var text = $(input_el).attr('placeholder')

            if (icons.includes(text.substr(text.length - 1))) {
                sortmanage(column, text, input_el)
            }
        }
    });

    $(".tablehead").keyup(function (){
        var key  = $(this).data('column').trim();
		var val = $(this).val().trim();
        if(val ==""){
            delete filterarr[key]
		}else{
            filterarr[key] = val;
		}
        console.log(filterarr)
        rebuild_table();
	})
    function rebuild_table() {
        copytable = tableData.slice(0);
        console.log(copytable.length)
        for (var t in filterarr){
            copytable = copytable.filter(function (obj){
                return obj[t].includes(filterarr[t])
            })
        }
        copytable = copytable.sort((a, b) => {
            for (var el of sortarr) {
                var column = Object.keys(el)[0];
                var order = el[column];
                if (order == 'desc') {
                    if (!isNaN(a[column]) && !isNaN(b[column])) {
                        if (parseInt(a[column]) > parseInt(b[column])) {
                            return 1;
                            break;
                        }
                        if (parseInt(a[column]) < parseInt(b[column])) {
                            return -1;
                            break;
                        }
                    } else {
                        if (a[column].toLowerCase() > b[column].toLowerCase()) {
                            return 1;
                            break;
                        }
                        if (a[column].toLowerCase() < b[column].toLowerCase()) {
                            return -1;
                            break;
                        }
                    }
                }
                if (order == 'asc') {
                    if (!isNaN(a[column]) && !isNaN(b[column])) {
                        if (parseInt(a[column]) > parseInt(b[column])) {
                            return -1;
                            break;
                        }
                        if (parseInt(a[column]) < parseInt(b[column])) {
                            return 1;
                            break;
                        }
                    } else {
                        if (a[column].toLowerCase() > b[column].toLowerCase()) {
                            return -1;
                            break;
                        }
                        if (a[column].toLowerCase() < b[column].toLowerCase()) {
                            return 1;
                            break;
                        }
                    }
                }
            }
        })
        state.querySet = copytable;
        buildTable();
    }

    function sortmanage(column, text, input_el) {
        manage_sort_arr(column, text, input_el)
        state.page = 1;
        rebuild_table();

    }

    function manage_sort_arr(column, text, input_el) {
        var types = ['desc', 'asc', 'normal']
        var col_var = '';
        var exists = sortarr.filter(function (o) {
            return o.hasOwnProperty(column);
        }).length > 0;
        var el = {};
        if (exists) {
            var clicked_obj = sortarr.findIndex(el => el.hasOwnProperty(column))
            var el = sortarr[clicked_obj];
            var index = types.indexOf(el[column]);
            if (index == types.length - 1) {
                col_var = 'desc'
            } else {
                col_var = types[index + 1];
            }
            sortarr.splice(clicked_obj, 1);
            el[column] = col_var;
            sortarr.push(el)
        } else {
            el[column] = 'desc'
            sortarr.push(el)
        }
        text = text.substring(0, text.length - 1)
        var index = getKeyByValue(types, el[column]);
        text += icons[index];
        $(input_el).attr('placeholder', text);
    }

    var state = {
        'querySet': tableData,
        'page': 1,
        'rows': 20,
        'window': 4,
    }

    buildTable()

    function getKeyByValue(object, value) {
        return Object.keys(object).find(key => object[key] === value);
    }

    function pagination(querySet, page, rows) {

        var trimStart = (page - 1) * rows
        var trimEnd = trimStart + rows

        var trimmedData = querySet.slice(trimStart, trimEnd)

        var pages = Math.round(querySet.length / rows);

        return {
            'querySet': trimmedData,
            'pages': pages,
        }
    }

    function pageButtons(pages) {
        var wrapper = document.getElementById('pagination-wrapper')

        wrapper.innerHTML = ``

        var maxLeft = (state.page - Math.floor(state.window / 2))
        var maxRight = (state.page + Math.floor(state.window / 2))

        if (maxLeft < 1) {
            maxLeft = 1
            maxRight = state.window
        }

        if (maxRight > pages) {
            maxLeft = pages - (state.window - 1)

            if (maxLeft < 1) {
                maxLeft = 1
            }
            maxRight = pages
        }


        for (var page = maxLeft; page <= maxRight; page++) {
            wrapper.innerHTML += `<button value=${page} class="page btn btn-sm btn_pagination ">${page}</button>`
        }

        if (state.page != 1) {
            wrapper.innerHTML = `<button value=${1} class="page btn btn-sm btn_pagination ">&#171;&#171; </button>` + wrapper.innerHTML
        }

        if (state.page != pages) {
            wrapper.innerHTML += `<button value=${pages} class="page btn btn-sm btn_pagination ">&#187;&#187;</button>`
        }

        $('.page').on('click', function () {
            $('#table-body').empty()

            state.page = Number($(this).val())

            buildTable()
        })

    }

    function buildTable() {
        var table = $('#table-body')
        table.empty();
        var data = pagination(state.querySet, state.page, state.rows)
        var myList = data.querySet

        for (var i in myList) {
            var row = `<tr>
                  <td>${myList[i].rank}</td>
                  <td>${myList[i].first_name}</td>
                  <td>${myList[i].last_name}</td>
                  <td>${myList[i].user_name}</td>`;

            table.append(row)
        }
        pageButtons(data.pages)
    }

    // });
</script>
</body>
</html>
