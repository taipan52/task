<?


/**
 * inputCreate function
 * Функция создающая обычный текстовый input
 * 
 * @param string $name
 * @param mixed $value
 * @param string $type
 *
 * @return string $html
 */
function inputCreate($name, $value='', $type='text') : string {
	
	$html = '';
	$ar_types = ['text', 'email', 'number', 'password', 'tel'];

	if( in_array($type, $ar_types)  ) {

		$name = str_replace(' ', '_', $name);
		$name = preg_replace('/[^_0-9a-zA-Z\[\]]/', '', $name);

		$value = strval($value);
		$value = htmlspecialchars($value, ENT_QUOTES);

		$html = sprintf('<input type="%1$s" name="%2$s" value="%3$s">', $type, $name, $value);
	}

	return $html;

}


/**
 * inputCheckboxCreate function
 * Функция, которая создает чекбокс и сохраняет его значение после отправки
 * 
 * @param string $name
 * @param boolean $checked
 *
 * @return string
 */
function inputCheckboxCreate($name, $checked=false) : string {
	
	$name = str_replace(' ', '_', $name);
	$name = preg_replace('/[^_0-9a-zA-Z]/', '', $name);

	$checked = boolval($checked);
	$checked_value = $checked ? 'checked' : '';

	return sprintf(
		'<input type="hidden" name="%1$s" value="0">
		<input type="checkbox" name="%1$s" id="%1$s" value="1" %2$s>
		<label for="%1$s">%1$s</label>', 
		$name, $checked_value);

}

//если число кратно 2 то квадрат числа, иначе число
$i = 1;
while($i <= 5) {

	if($i % 2 == 1) {
		echo $i.'<br>';
	}
	else {
		echo $i*$i.'<br>';
	}

	$i++;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<title>Документ</title>
</head>
<body>
	<div class="container">

	<pre><?print_r($_REQUEST)?></pre>

	<form action="">
		<?=inputCheckboxCreate('CHBX', true)?><br>
		<?=inputCreate('PASS', '"ZX7hn3?G%yQa}Gi', 'password')?><br>
		<br>
		<button>Отправить</button>
	</form>

<button type="button" class="btn btn-primary open_modal">Открыть окно</button>

<script
	src="https://code.jquery.com/jquery-3.6.1.min.js"
	integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
	crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</div>

<script>



/**
 * Напишите функцию на JavaScript с использованием jQuery, 
 * которая принимает URL, делает GET-запрос на сервер и отображает ответ (или ошибку) в модальном окне Bootstrap. 
 * Окно должно открываться при вызове функции без какой-либо задержки. 
 * Ответ содержит произвольный HTML-код, не требующий дополнительной обработки.
 * 
 * @param url
 * @return void
 */
function GetAns(url) {
	
	function show(target, html){
		$(target).find('.modal-body')
			.html(html)
			.after(
				'<div class="modal-footer">\
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>\
				</div>'
			);
	}

	var modalHtml = $(
		'<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">\
		    <div class="modal-dialog">\
		        <div class="modal-content">\
		            <div class="modal-header">\
		                <h5 class="modal-title" id="modalLabel">Ответ сервера</h5>\
		            </div>\
		            <div class="modal-body">\
						<div class="text-center">\
							<div class="spinner-border" role="status">\
								<span class="visually-hidden">Загрузка...</span>\
							</div>\
						</div>\
		            </div>\
		        </div>\
		    </div>\
		</div>');
		modal = new bootstrap.Modal(modalHtml, {});


	modalHtml.on('show.bs.modal', function(){

		$.ajax({
			url,
			method: 'get',
			dataType: 'html',
			context: this
		}).done(function(ans){

			show(this, ans);

		}).fail(function(){

			show(this, '<div class="alert alert-danger">Ошибка!</div>');
		})

	})


	modal.show();

}

//событие вызова
$('.open_modal').on('click', function(){
	GetAns('ajax.php');
})



</script>

</body>
</html>