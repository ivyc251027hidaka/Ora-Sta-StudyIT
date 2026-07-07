<?php

namespace Database\Seeders;

use App\Models\Word;
use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    public function run(): void
    {
        $words = [
            [
                'term' => 'SELECT',
                'description' => 'テーブルからデータを取得するSQL文。取得するカラムを指定する。',
                'sql_example' => "SELECT id, name, email FROM users;",
                'section' => 'SELECT',
                'difficulty' => 'easy',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'WHERE',
                'description' => '条件を指定してデータを絞り込む句。',
                'sql_example' => "SELECT * FROM users WHERE age >= 20;",
                'section' => 'SELECT',
                'difficulty' => 'easy',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'ORDER BY',
                'description' => '取得結果を指定したカラムで並び替える句。ASC（昇順）またはDESC（降順）を指定できる。',
                'sql_example' => "SELECT * FROM users ORDER BY created_at DESC;",
                'section' => 'SELECT',
                'difficulty' => 'easy',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'GROUP BY',
                'description' => '指定したカラムの値でグループ化する句。集計関数と組み合わせて使う。',
                'sql_example' => "SELECT department, COUNT(*) FROM employees GROUP BY department;",
                'section' => '集計',
                'difficulty' => 'normal',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'HAVING',
                'description' => 'GROUP BYでグループ化した結果にさらに条件を指定する句。WHEREと違い集計関数が使える。',
                'sql_example' => "SELECT department, COUNT(*) FROM employees GROUP BY department HAVING COUNT(*) >= 5;",
                'section' => '集計',
                'difficulty' => 'normal',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'INNER JOIN',
                'description' => '2つのテーブルで一致するデータだけを結合して取得するJOIN。ON句で結合条件を指定する。',
                'sql_example' => "SELECT e.name, d.department_name\nFROM employees e\nINNER JOIN departments d ON e.department_id = d.id;",
                'section' => 'JOIN',
                'difficulty' => 'normal',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'LEFT JOIN',
                'description' => '左テーブルのすべてのレコードと、右テーブルで一致するレコードを結合する。右テーブルに一致がない場合はNULLになる。',
                'sql_example' => "SELECT e.name, d.department_name\nFROM employees e\nLEFT JOIN departments d ON e.department_id = d.id;",
                'section' => 'JOIN',
                'difficulty' => 'normal',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'DISTINCT',
                'description' => '重複する行を除いてデータを取得するキーワード。',
                'sql_example' => "SELECT DISTINCT department FROM employees;",
                'section' => 'SELECT',
                'difficulty' => 'easy',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'COUNT',
                'description' => '行数を数える集計関数。COUNT(*)は全行数、COUNT(カラム名)はNULL以外の行数を返す。',
                'sql_example' => "SELECT COUNT(*) FROM users;\nSELECT COUNT(email) FROM users;",
                'section' => '集計',
                'difficulty' => 'easy',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'SUM',
                'description' => '指定したカラムの合計値を返す集計関数。',
                'sql_example' => "SELECT SUM(price) FROM orders;",
                'section' => '集計',
                'difficulty' => 'easy',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'AVG',
                'description' => '指定したカラムの平均値を返す集計関数。',
                'sql_example' => "SELECT AVG(salary) FROM employees;",
                'section' => '集計',
                'difficulty' => 'easy',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'MAX',
                'description' => '指定したカラムの最大値を返す集計関数。',
                'sql_example' => "SELECT MAX(price) FROM products;",
                'section' => '集計',
                'difficulty' => 'easy',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'MIN',
                'description' => '指定したカラムの最小値を返す集計関数。',
                'sql_example' => "SELECT MIN(price) FROM products;",
                'section' => '集計',
                'difficulty' => 'easy',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'SUBQUERY',
                'description' => 'SELECT文の中に別のSELECT文を入れ子にしたもの。サブクエリとも呼ぶ。',
                'sql_example' => "SELECT name FROM employees\nWHERE salary > (SELECT AVG(salary) FROM employees);",
                'section' => 'サブクエリ',
                'difficulty' => 'hard',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'EXISTS',
                'description' => 'サブクエリが1件以上の結果を返す場合にTRUEとなる演算子。',
                'sql_example' => "SELECT name FROM customers c\nWHERE EXISTS (\n  SELECT 1 FROM orders o WHERE o.customer_id = c.id\n);",
                'section' => 'サブクエリ',
                'difficulty' => 'hard',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'IN',
                'description' => '指定したリストの中にカラムの値が含まれるかどうかを判定する演算子。',
                'sql_example' => "SELECT * FROM products WHERE category IN ('食品', '飲料', '日用品');",
                'section' => 'SELECT',
                'difficulty' => 'easy',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'LIKE',
                'description' => '文字列のパターンマッチングを行う演算子。%は任意の文字列、_は任意の1文字を表す。',
                'sql_example' => "SELECT * FROM users WHERE name LIKE '田%';",
                'section' => 'SELECT',
                'difficulty' => 'easy',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'NULL',
                'description' => '値が存在しないことを表す特殊な値。IS NULLまたはIS NOT NULLで判定する。=演算子では比較できない。',
                'sql_example' => "SELECT * FROM users WHERE email IS NULL;",
                'section' => 'SELECT',
                'difficulty' => 'normal',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'CASE',
                'description' => '条件によって異なる値を返す式。プログラミングのif文に相当する。',
                'sql_example' => "SELECT name,\n  CASE\n    WHEN score >= 80 THEN '優'\n    WHEN score >= 60 THEN '良'\n    ELSE '可'\n  END AS grade\nFROM students;",
                'section' => '関数',
                'difficulty' => 'normal',
                'quiz_type' => 'choice',
            ],
            [
                'term' => 'PRIMARY KEY',
                'description' => 'テーブルの各行を一意に識別するための制約。NULL不可かつ重複不可。',
                'sql_example' => "CREATE TABLE users (\n  id INT PRIMARY KEY,\n  name VARCHAR(100)\n);",
                'section' => 'テーブル設計',
                'difficulty' => 'normal',
                'quiz_type' => 'choice',
            ],
        ];

        foreach ($words as $word) {
            Word::firstOrCreate(['term' => $word['term']], $word);
        }
    }
}