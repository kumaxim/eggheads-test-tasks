/*
  Имеем следующие таблицы:
    1. users — контрагенты
        - id
        - name
        - phone
        - email
        - created — дата создания записи
    2. orders — заказы
        - id
        - subtotal — сумма всех товарных позиций
        - created — дата и время поступления заказа (Y-m-d H:i:s)
        - city_id — город доставки
        - user_id

    Необходимо выбрать одним запросом следующее (следует учесть, что будет включена опция only_full_group_by в MySql):
    1. Имя контрагента
    2. Его телефон
    3. Сумма всех его заказов
    4. Его средний чек
    5. Дата последнего заказа


  Примечание: identifier.sqlite - база с заданной структурой и парой записей, по которой проверялся запрос
 */

 select
        users.name,
        users.phone,
        SUM(orders.subtotal),
        AVG(orders.subtotal),
        (select created from orders as history where history.user_id = users.id order by history.created desc limit 1) as last_order
 from users
    join orders on orders.user_id = users.id
order by users.name, users.phone