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
![IMG_4527](https://github.com/user-attachments/assets/a8f676c7-4611-43b8-84a3-d809da9886dc)

# 機能改修や機能作成の流れ
- issueに目的や機能の概要、要件を記入する
- reviewerに起案者を選択する
- ※実装者からレビュー依頼が来たら問題なく実装できているか確認し、問題なければアプルーブする

# issue実装の流れ
- issueのasigneeに実装者を選択する
- 実装者とissue番号に対応するブランチを作成する
    - 例) ・実装者: ラッコ　 ・issue番号: 2　の場合
    - `rakko/2`
- pushしたらPRにissueのリンクを貼り付ける
- 実装が完了したら起案者にレビューを依頼する
- アプルーブが完了したら、mainへマージする
