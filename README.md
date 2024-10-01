# 在庫管理システム
- 商品の在庫を管理するアプリケーション
- nextjs + laravelAPIを使って作成する
- nextjsには`https://github.com/laravel/breeze-next.git`を使用

# DB
DBの構成情報を記述する。
laravelにおいて、デフォルトで作成される値(idやcreate_atなど)は記載しない。
- 商品(Products)
  - 名前
  - 価格
- 会社(Companies)
  - 名前
- 注文(Orders)
  - 商品id
  - 企業id
  - 注文数
  - 出荷フラグ
 
# 画面イメージ
![IMG_4527 2](https://github.com/user-attachments/assets/c795312f-0af1-41de-b630-5d06ecbcf4e7)
