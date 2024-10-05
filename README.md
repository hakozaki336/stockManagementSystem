# 在庫管理システム
- 商品の在庫を管理するアプリケーション
- nextjs + laravelAPIを使って作成する
- nextjsには`https://github.com/laravel/breeze-next.git`を使用
    - `breeze-next.git`: laravelのbreezeをそのまま使うことができるライブラリ
- フロントエンドのスタイルにはテールウィンド cssを使用する

# DB
DBの構成情報を記述する。
laravelにおいて、デフォルトで作成される値(idやcreate_atなど)は記載しない。
- 商品(Products)
    - 名前
    - 価格
    - 個数
- 会社(Companies)
    - 名前
- 注文(Orders)
    - 商品id
    - 企業id
    - 注文数
    - 出荷フラグ
 
# 画面イメージ
![IMG_4527](https://github.com/user-attachments/assets/a8f676c7-4611-43b8-84a3-d809da9886dc)

# 機能改修や機能作成起案の流れ
- issueに目的や機能の概要、要件を記入する
- 起案者は自身のreviewerラベルを選択する
- ※任意だが、`バックエンド`か`フロントエンド`かのラベルはつけてほしい
- ※実装者からレビュー依頼が来たら問題なく実装できているか確認し、問題なければアプルーブする

# issue実装の流れ
- issueのasigneeに実装者を選択する
- 実装者とissue番号に対応するブランチを作成する
    - 例) ・実装者: ラッコ　 ・issue番号: 2　の場合
    - `rakko/2`
- pushしたらPRにissueのリンクを貼り付ける
- 実装が完了したら起案者にレビューを依頼する
- アプルーブが完了したら、mainへマージする

# メモ
- データを取得時には、`with`を使用して関連モデルも一緒に取得することにする。
- また、関連モデルを取得すは標準の挙動とするためメソッド名に`with`を明記しない。
  - 例 :`Order`モデルを取得する時に、`Product`、`Company`も`with`で一緒に取得する。
  - メソッド命名の例:
    - O: getProducts
    - X: getProductsWithRelations
