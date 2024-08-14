# AsiaYo Exam
### Rona Yeh
* * *
### 資料庫測驗
#### 題目1：
請寫出一條查詢語句 (SQL)，列出在 2023 年 5 月下訂的訂單，使用台幣付款且5月總金額最 多的前 10 筆的旅宿 ID (bnb_id), 旅宿名稱 (bnb_name), 5 月總金額 (may_amount)
#### 答案1：
_假設 orders 的 created_at 為 UTC 時區，且查詢的是台灣時間 2024年5月_
<code>SELECT 
` `bnbs.id AS bnb_id,
` `bnbs.name AS bnb_name,
` `SUM(orders.amount) AS may_amount
FROM orders
JOIN
` `bnbs ON orders.bnb_id = bnbs.id
WHERE
` `orders.currency = 'TWD'
` `AND orders.created_at >= '2023-04-30 16:00:00'
` `AND orders.created_at < '2023-05-31 16:00:00'
GROUP BY
` `bnbs.id, bnbs.name
ORDER BY
` `may_amount DESC
LIMIT 10</code>
#### 題目2：
在題目一的執行下，我們發現 SQL 執行速度很慢，您會怎麼去優化?請闡述您怎麼判斷與優 化的方式
#### 答案2：
1. 使用 EXPLAIN 確認目前資料表是否有索引、是否全表掃描
2. 對 orders.currency 及 orders.created_at 建立索引，減少掃描時間
3. 如果 orders 資料量大，會造成記憶體大量使用，可以先對 orders 做 sub query，再 JOIN bnbs
   作法：
<code>SELECT 
` `bnbs.id AS bnb_id,
` `bnbs.name AS bnb_name,
` `SUM(filter_orders.amount) AS may_amount
FROM 
` `(SELECT id, bnb_id, amount, created_at
` `FROM orders 
` `WHERE currency = 'TWD'
` `AND created_at >= '2023-04-30 16:00:00'
` `AND created_at < '2023-05-31 16:00:00') filter_orders
JOIN
` `bnbs ON filter_orders.bnb_id = bnbs.id
GROUP BY
` `bnbs.id, bnbs.name
ORDER BY
` `may_amount DESC
LIMIT 10</code>
* * *
### API實作測驗
#### 題目1：
說明所使用的 SOLID 與設計模式分別為何
#### 答案1：
**SOLID - SRP**:<br>
`OrderController`：負責處理 HTTP 請求及 Response<br>
`OrderPostRequest` : 負責驗證 HTTP 請求資料<br>
`OrderService` : 負責業務邏輯<br>
`OrderExceptions` : 負責處理異常狀況<br>
各個 Class 都有自己單一的權責。<br>
**SOLID - OCP**:<br>
把業務邏輯封裝在 `OrderService` 中，可以透過加入更多 function 來修改及擴充業務邏輯。<br>
使用 `BaseJsonException` 可以擴充更多業務邏輯錯誤。<br>
**SOLID - LSP**:<br>
`OrderPriceOverException` 跟 `OrderNameFormatException` 繼承 `BaseJsonException`，可以在其他 Exception 繼承 `BaseJsonException` 而不會影響原有的 `OrderPriceOverException` 跟 `OrderNameFormatException`。<br>
**SOLID - ISP**:<br>
使用 `JsonExceptionInterface` 及 `BaseLoggerExceptionInterface` 隔離各個 Exception 印 Log 的能力，實作可以看到 `OrderPriceOverException` 是 implement `BaseLoggerException`，當發生錯誤時可以印出超過的金額是多少錢。<br>
**SOLID - DIP**:<br>
在 `OrderController` 中，在 construct DI 注入抽象 OrderService，而不是在使用時 new OrderService。<br>
**設計模式**:<br>
1. Dependency Injection Pattern：在 `OrderController` 中，在 construct 依賴注入 `OrderService`
2. Strategy Pattern：在 `OrderService` 中不同驗證方式可以替換成不同策略或擴充

* * *
### 個人提問：
1. 格式檢查與轉換都可以在 OrderPostRequest 完成，除非是複雜且可重用邏輯才需要放入 Service 層。
2. 循序圖在 Form Validation 檢查必要欄位及欄位型態時，若有驗證錯誤，應該使用 [Opt] 區塊直接傳入 Response 回應結果。
3. Price 欄位為什麼使用字串？
