<?php

     // функция преобразования целого числа в число прописью
// в конце добавляется слово "рубль" в нужной форме
function propis($rub)
{
$dop0 = Array("рублей","тысяч","миллионов","миллиардов");
$dop1 = Array("рубль","тысяча","миллион","миллиард");
$dop2 = Array("рубля","тысячи","миллиона","миллиарда");
$s1 = Array("","один","два","три","четыре","пять","шесть","семь","восемь","девять");
$s11 = Array("","одна","две","три","четыре","пять","шесть","семь","восемь","девять");
$s2 = Array("","десять","двадцать","тридцать","сорок","пятьдесят","шестьдесят","семьдесят","восемьдесят","девяносто");
$s22 = Array("десять","одиннадцать","двенадцать","тринадцать","четырнадцать","пятнадцать","шестнадцать","семнадцать","восемнадцать","девятнадцать");
$s3 = Array("","сто","двести","триста","четыреста");

if($rub==0)
{// если это 0
return "ноль ".$dop0[0];
}

// разбиваем полученное число на тройки и загоняем в массив $triplet
$t_count = ceil(strlen($rub)/3);
for($i=0;$i<$t_count;$i++)
{
$k = $t_count - $i - 1;
$triplet[$k] = $rub%1000;
$rub = floor($rub/1000);
}

// пробегаем по триплетам
for($i=0;$i<$t_count;$i++)
{
$t = $triplet[$i]; // это текущий триплет - с ним и работаем
$k = $t_count - $i - 1;
$n1 = floor($t/100);
$n2 = floor(($t-$n1*100)/10);
$n3 = $t-$n1*100-$n2*10;

// обрабатываем сотни
if($n1<5) $res .= $s3[$n1]." ";
elseif($n1) $res .= $s1[$n1]."сот ";

if($n2>1)
{// второй десяток
$res .= $s2[$n2]." ";
if($n3 and $k==1)
{// если есть единицы в триплете и это триплет ТЫСЯЧ
$res .= $s11[$n3]." ";
}
elseif($n3)
{
$res .= $s1[$n3]." ";
}
}
elseif($n2==1)
{
$res .= $s22[$n3]." ";
}
elseif($n3 and $k==1)
{// если есть единицы в триплете и это триплет ТЫСЯЧ
$res .= $s11[$n3]." ";
}
elseif($n3)
{
$res .= $s1[$n3]." ";
}

// прилепляем в конец триплета коммент
if($n3==1 and $n2!=1)
{// в конце триплета стоит 1, но не 11.
$res .= $dop1[$k]." ";
}
elseif($n3>1 and $n3<5 and $n2!=1)
{// в конце триплета стоит 2, 3 или 4, но не 12, 13 или 14
$res .= $dop2[$k]." ";
}
elseif($t or $k==0)
{
$res .= $dop0[$k]." ";
}
}
return $res;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ru">
    <head>
        <title>Печать счета</title>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
        <meta http-equiv="Content-Language" content="ru">
        <style type="text/css">
            code { white-space: pre; }
            .nowr { white-space: nowrap; }
            td { padding: 0; border: 0;}
            table { border: none; }
            img { border: none; }
            form { margin: 0px; padding: 0px; }
        </style>
        <style type="text/css">
            body { background-color: white; margin: 0px; text-align: center; }
        </style>
        <style type="text/css">
            input { margin-bottom: 8pt; margin-top: 8pt; }
            a { text-decoration: none; color: #555; }
            a:hover { text-decoration: underline; }
            #toolbox { font-family: Arial, sans-serif; font-size: 9pt; border-bottom: dashed 1pt black; margin-bottom: 30px; padding: 2mm 0 0 0; text-align: justify; }
            #invoice { width:180mm; font-family: Arial, sans-serif;  margin-left: auto; margin-right: auto; text-align:left; }
            #shop_info, #shop_info td{ border:solid 1px #000; }
            #shop_info { margin-top: 5mm; }
            #shop_info td{ padding:5px; }
            #items, #items td, #items th{ border:solid 1px #000; }
            #items { margin-top: 5mm; margin-bottom:5mm; }
            #items td, #items th{ padding:5px; }
            p { margin: 2pt 0 2pt 0; }
            h1{ text-align:center; }
        </style>
        <style type="text/css" media="print">
            #toolbox { display: none; }
        </style>
        <style type="text/css" media="screen">
            #toolbox { width: 180mm; margin-left: auto; margin-right: auto; }
        </style>
    </head>

    <body>

        <div id="toolbox">
            <h2>Cчет на оплату заказа</h2>
            <p>
                Вы можете сохранить счет на свой компьютер, выбрав &laquo;Файл &rarr; Cохранить как&raquo; в меню браузера.<br/>
                <strong>После распечатки счета нажмите кнопку &laquo;Продолжить&raquo;</strong>
            </p>
            <form id="frm" method="post" action="/shop/get-payment/bill">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                <input type="hidden" name="osk" value="<?php echo $order['secret_key']; ?>" />
                <input type="hidden" name="currency" value="RUR" />
                <input type="hidden" name="client_sess_id" value="<?php echo session_id(); ?>" />
                <input type="button" value="Напечатать" onclick="window.print();" />
                <input type="submit" name="modify" value="Продолжить &rarr;" />
            </form>
        </div>


        <div id="invoice">

            <div><strong><?php echo $bill['config']['BILL_SHOP']['value']; ?></strong></div>
            <div><strong><?php echo $bill['config']['BILL_SHOP_ADDR']['value']; ?></strong></div>

            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="shop_info">
                <tr>
                    <td><strong>ИНН</strong> <?php echo $bill['config']['BILL_SHOP_INN']['value']; ?></td>
                    <td><strong>КПП</strong> <?php echo $bill['config']['BILL_SHOP_KPP']['value']; ?></td>
                    <td rowspan="3" valign="bottom">Cчет №</td>
                    <td rowspan="3" valign="bottom"><?php echo $bill['config']['BILL_SHOP_ACC']['value']; ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="border-bottom:none"><strong>Получатель</strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top:none"><?php echo $bill['config']['BILL_SHOP']['value']; ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="border-bottom:none"><strong>Банк получателя</strong></td>
                    <td>БИК</td>
                    <td style="border-bottom:none"><?php echo $bill['config']['BILL_SHOP_BIK']['value']; ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top:none"><?php echo $bill['config']['BILL_SHOP_BANK']['value']; ?></td>
                    <td>Счет №</td>
                    <td style="border-top:none"><?php echo $bill['config']['BILL_SHOP_KS']['value']; ?></td>
                </tr>
            </table>

            <h1>СЧЕТ № <?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?> от <?php echo date('d') . ' ' . $_LANG['MONTH_'.date(m)] . ' ' . date('Y'); ?></h1>

            <div><strong>Покупатель:</strong> <?php echo $order['customer_org']; ?>, ИНН <?php echo $order['customer_inn']; ?>, <?php echo $order['customer_address']; ?></div>

            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="items">
                <tr class="first">
                    <th>№</td>
                    <th>Наименование товара, работ, услуг</td>
                    <th>Ед.&nbsp;изм.</td>
                    <th>Кол-во</td>
                    <th>Цена</td>
                    <th>Сумма</td>
                </tr>
                <?php foreach($order['items'] as $id=>$item){ ?>
                    <tr>
                        <td><?php echo ($id+1); ?></td>
                        <td><?php echo $item['title']; ?> <?php if ($item['var_title']) { echo '('.$item['var_title'].')'; } ?></td>
                        <td align="center"><?php echo $_LANG['SHOP_PIECES']; ?></td>
                        <td align="right"><?php echo $item['cart_qty']; ?></td>
                        <td align="right"><?php echo number_format(round($item['price']/$currency_kurs, 2), 2, '.', '\''); ?></td>
                        <td align="right"><?php echo number_format(round($item['price']/$currency_kurs, 2)*$item['cart_qty'], 2, '.', '\''); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td align="right" colspan="5" style="border-bottom:none"><strong>Итого:</strong></td>
                    <td align="right"><?php echo number_format($order['summ'], 2, '.', '\''); ?></td>
                </tr>
                <?php $nds = intval($bill['config']['BILL_SHOP_NDS']['value']); ?>
                <?php if ($nds){ ?>
                    <tr>
                        <td align="right" colspan="5" style="border-bottom:none;border-top:none;"><strong>В том числе НДС (<?php echo $nds; ?>%):</strong></td>
                        <td align="right"><?php echo number_format($order['summ']*($nds/100), 2, '.', '\''); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td align="right" colspan="5" style="border-top:none;"><strong>Всего к оплате:</strong></td>
                    <td align="right"><?php echo number_format($order['summ'], 2, '.', '\''); ?></td>
                </tr>
            </table>

            <div style="margin-top:4mm">Всего наименований <?php echo sizeof($order['items']); ?>, на сумму <?php echo number_format($order['summ'], 2, '.', '\''); ?> <?php echo $cfg['currency']; ?></div>

            <div style="margin-bottom:3mm"><strong><?php echo ucfirst(propis($order['summ_parts'][0])); ?> <?php echo $order['summ_parts'][1]; ?> копеек</strong></div>

            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:6mm;margin-bottom:6mm">
                <tr>
                    <td>Руководитель предприятия:</td>
                    <td style="border-bottom:solid 1px #000;width:33%">&nbsp;</td>
                    <td width="150" align="center">(<?php echo $bill['config']['BILL_SHOP_DIR']['value']; ?>)</td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10mm">
                <tr>
                    <td>Главный бухгалтер:</td>
                    <td style="border-bottom:solid 1px #000;width:33%">&nbsp;</td>
                    <td width="150" align="center">(<?php echo $bill['config']['BILL_SHOP_BUH']['value']; ?>)</td>
                </tr>
            </table>

        </div>

    </body>

</html>