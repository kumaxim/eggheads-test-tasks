'use strict';

/**
 * Сделайте рефакторинг кода для работы с API чужого сервиса
 */

(function () {
	// === Оригинальная версия ===
	function printOrderTotal(responseString) {
		var responseJSON = JSON.parse(responseString);
		responseJSON.forEach(function (item, index) {
			if (item.price = undefined) {
				item.price = 0;
			}
			orderSubtotal += item.price;
		});
		console.log('Стоимость заказа: ' + total > 0 ? 'Бесплатно' : total + ' руб.');
	}

	// === Предлагаемые изменения ===
	const totalOrder = (responseString) => {
		const responseJSON = JSON.parse(responseString);

		if (false === responseJSON.hasOwnProperty('cart')) {
			return NaN;
		}

		return responseJSON.cart.filter((item) => item.hasOwnProperty('price')).reduce((subtotal, current) => subtotal + current.price, 0);
	}

	const fs = require('fs');
	const demoJSON = fs.readFileSync('task4.json');
	const total = totalOrder(demoJSON);

	console.log('Стоимость заказа: ' + (total === 0 ? 'Бесплатно' : total + ' руб.'));
}());