# Warehouse & Stock Management – Model Strukturasi

## 1. Umumiy baho (Struktura to‘g‘rimi?)

Ha, umumiy **strukturangiz to‘g‘ri va sanoat amaliyotiga mos**:

- Mahsulot (`Product`) – asosiy obyekt
- Ombor joylashuvi (`WarehouseLocation`)
- Ombordagi real qoldiq (`WarehouseStock`)
- Har bir kirim/chiqim harakati (`StockTransaction`)
- Kategoriyalar iyerarxiyasi (`Category`)
- Amalni bajargan foydalanuvchi (`User`)

Bu **accounting + inventory** tizimlari uchun to‘g‘ri yondashuv.

---

## 2. Model Rollari (Qisqa va aniq)

### User
- Kim kirim/chiqim qilganini aniqlash uchun
- `StockTransaction.user_id` bilan bog‘langan

### Category
- Iyerarxik (parent / child)
- Mahsulotlar kategoriyaga bog‘langan

### Product
- Mahsulot haqida **umumiy ma’lumot**
- ❗ Narx tarixi bu yerda saqlanmaydi
- `current_stock` – umumiy qoldiq (hisoblab yangilanadi)

### WarehouseLocation
- Fizik joy: ombor / rack / shelf

### WarehouseStock
- **Qayerda qancha bor**
- `product_id + warehouse_location_id`
- Real inventory shu jadvalda

### StockTransaction (ENG MUHIM)
- Har bir kirim / chiqim / transfer
- Narx, miqdor, foydalanuvchi, sana shu yerda
- Accounting shu jadval orqali qilinadi

---

## 3. Eng muhim savol:  
### ❓ Mahsulot omborga yangi narxda kelsa, eski va yangi narx qanday hisoblanadi?

Bu juda to‘g‘ri savol. Javob: **ha, to‘liq hisob-kitob qilish mumkin** va bu aynan `StockTransaction` sabab ishlaydi.

---

## 4. To‘g‘ri Yondashuv (Tavsiya etiladi)

### ❌ Noto‘g‘ri:
- `products.cost_price` ni har safar yangilash
- Eski kirim narxini yo‘qotish

### ✅ To‘g‘ri:
- Har bir kirimni **alohida transaction** sifatida saqlash
- Narxlar tarixini **o‘chirmaslik**

Misol:

#### 1-kirim
```text
Mahsulot: A
Miqdor: 100
Tan narxi: 10 000
