<?php
// モンテカルロ法サンプルプログラム

define('EPOCH_NUM', 100000);// 最大ゲーム回数
define('MANGNIFICATION', 2);// ゲームの倍率

$balance = 0;
$max_bet = 0;
$min_balance = 0;
$bet_array = [1,2,3];

for ($i = 0; $i < EPOCH_NUM; ++$i) {
    $_end_point = count($bet_array) - 1;
    $bet = $bet_array[0] + $bet_array[$_end_point];

    // 最大BETの記録
    if ($bet > $max_bet) {
        $max_bet = $bet;
    }

    list($result, $return) = Game($bet);

    switch ($result) {
        case true:
            # Win
            unset($bet_array[0], $bet_array[$_end_point]);
            $bet_array = array_values($bet_array);

            $balance += $return;
            break;
        case false:
            # Lose
            $bet_array[] = $bet;

            $balance += $return;

            // 最低収支の記録
            if ($balance < $min_balance) {
                $min_balance = $balance;
            }
            break;
    }

    echo '---' . ($i + 1) . 'エポック目の結果---' . PHP_EOL;
    $result_str = ($result) ? '勝ち' : '負け';
    printf("%s \t %s \t 収支 %s".PHP_EOL, $result_str, $return, $balance);

    if (empty($bet_array)) {
        echo 'エポック終了'.PHP_EOL;
        break;
    }
}

echo '_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/'.PHP_EOL;
printf("\t 合計ゲーム数（エポック数）:　%s（%s）".PHP_EOL, $i, EPOCH_NUM);
printf("\t 最終収支:　%s".PHP_EOL, $balance);
printf("\t 最低収支:　%s".PHP_EOL, $min_balance);
printf("\t 最大BET:　%s".PHP_EOL, $max_bet);
echo '_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/'.PHP_EOL;

function Game($bet): array
{
    $game_result = rand(1, MANGNIFICATION);

    // Win
    if ($game_result === 1) {
        return [true, $bet * MANGNIFICATION];
    }

    // Lose
    return [false, $bet * -1];
}