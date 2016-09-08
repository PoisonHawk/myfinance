<?php

return array(
	
	
	'custom' => array(
		'email' => array(
			'required' => 'Поле :attribute должно быть заполнено',
			'These credentials do not match our records' => 'Неправильные логин или пароль',
			'unique'               => 'Пользователь с таким email уже существует',
		),
		'password' => array(
			'required' => 'Поле :attribute должно быть заполнено',
		),
		'auth' => array(
			'failed' => 'Неправильные логин или пароль',
		)
	),
	'auth' => array(
			'failed' => 'Неправильные логин или пароль',
		)
);
