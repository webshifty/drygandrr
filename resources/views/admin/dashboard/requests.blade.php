@extends('admin.dashboard.components.page')

@section('content')
<div class="questions-block">
	<table>
		<tr>
			<th>Запитання</th>
			<th>Користувач</th>
			<th>Статус</th>
			<th>Дата</th>
		</tr>
		<tr>
			<td>Оформлення паспортних документів</td>
			<td>Анастасія Кур</td>
			<td>Нове</td>
			<td>5 хвилин назад</td>
		</tr>
	</table>
</div>
@endsection

@section('modal')
<form action="">
	<h3>Надати відповідь</h3>
	<div class="fieldset ">
		<div class="field styling-label">
			<label>Країна</label>
			<input name="country" type="text" value="Австрія" >
		</div>
		<div class="field styling-label">
			<label>Категорія</label>
			<select>
				<option>Австрія</option>
				<option>Китай</option>
			</select>
		</div>
		<div class="field styling-label">
			<label>Статус</label>
			<select>
				<option>Виконується</option>
				<option>Китай</option>
			</select>               
		</div>
	</div>
	<div class="field styling-label">
		<label>Питання</label>
		<input name="question" type="text" value="Неординарне запитання" >
	</div>
	<div class="field styling-label">
		<label>Відповідь</label>
		<textarea name="answer" value="Неординарне запитання" ></textarea>
	</div>
	<div class="field-checkbox">
		<label>Додавати в базу</label>
		<input type="checkbox" name="add" value="add" >
	</div>
	<div class="actions">
		<button class="button">Надіслати</button>
		<button class="button secondary close">Відхилити</button>
	</div>
</form>
@endsection
