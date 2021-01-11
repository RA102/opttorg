<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ru">
    <head>
        <title>Печать квитанции формы ПД-4</title>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
        <meta http-equiv="Content-Language" content="ru">
        <style type="text/css">
            code { white-space: pre; }
            .nowr { white-space: nowrap; }
            td { padding: 0; border: 0;}
            table { border: none; }
            img { border: none; }
            form { margin: 0px; padding: 0px; }
            sup { font-size: 66%; line-height: .5; }
            li { list-style: square outside; padding: 0px; margin: 0px; }
            ul { list-style: square outside; padding: 0em 0em 0em 0em; margin: 0em 0em 0em 1.5em; }
            .fakelink { cursor: pointer; }
            .centered { margin-left: auto; margin-right: auto; }
            .zerosize { font-size: 1px; }
            .w100 { width: 100%; }
            .h100 { height: 100%; }
            .underlined { text-decoration: underline; }
            .bolded { font-weight: bold; }
        </style>
        <style type="text/css">
            body { background-color: white; margin: 0px; text-align: center; }
            .ramka { border-top: black 1px dashed; border-bottom: black 1px dashed; border-left: black 1px dashed; border-right: black 1px dashed; margin: 4mm auto 12mm auto; height: 145mm; }
            .kassir { font-weight: bold; font-size: 10pt; font-family: "Times New Roman", serif; padding: 7mm 0 7mm 0; text-align: center; }
            .cell { font-family: Arial, sans-serif; border-left: black 1px solid; border-bottom: black 1px solid; border-top: black 1px solid; font-weight: bold; font-size: 8pt; line-height: 1.1; height: 4mm; vertical-align: bottom; text-align: center; }
            .cells { border-right: black 1px solid; width: 100%; }
            .subscript { font-size: 6pt; font-family: "Times New Roman", serif; line-height: 1; vertical-align: top; text-align: center; }
            .string, .dstring { font-weight: bold; font-size: 8pt; font-family: Arial, sans-serif; border-bottom: black 1px solid; text-align: center; vertical-align: bottom; }
            .dstring { font-size: 9pt; letter-spacing: 1pt; }
            .floor { vertical-align: bottom; padding-top: 0.5mm; }
            .stext { font-size: 8.5pt; font-family: "Times New Roman", serif; vertical-align: bottom; }
            .stext7 { font-size: 7.5pt; font-family: "Times New Roman", serif; vertical-align: bottom; }
        </style>
        <style type="text/css">
            input { margin-bottom: 8pt; margin-top: 8pt; }
            a { text-decoration: none; color: #555; }
            a:hover { text-decoration: underline; }
            #toolbox { font-family: Arial, sans-serif; font-size: 9pt; border-bottom: dashed 1pt black; margin-bottom: 10px; padding: 2mm 0 0 0; text-align: justify; }
            p { margin: 2pt 0 2pt 0; }
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
            <h2>Квитанция СберБанка РФ для оплаты заказа</h2>
            <p>
                Квитанция формы &laquo;&#8470; ПД-4&raquo; свободно располагается на листе формата А4.<br/>
                Как правило, никаких особых настроек печати не требуется. Верстка квитанции предоставлена проектом <a href="http://quittance.ru/" target="_blank">quittance.ru</a><br/><br/>
                Вы можете сохранить квитанцию на свой компьютер, выбрав &laquo;Файл &rarr; Cохранить как&raquo; в меню браузера.<br/>
                <strong>После распечатки квитанции нажмите кнопку &laquo;Продолжить&raquo;</strong>
            </p>
            <form id="frm" method="post" action="/shop/get-payment/sberbank">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                <input type="hidden" name="osk" value="<?php echo $order['secret_key']; ?>" />
                <input type="hidden" name="currency" value="RUR" />
                <input type="hidden" name="client_sess_id" value="<?php echo session_id(); ?>" />
                <input type="button" value="Напечатать" onclick="window.print();" />
                <input type="submit" name="modify" value="Продолжить &rarr;" />
            </form>
        </div>

<table class="ramka" cellspacing="0" style="width: 180mm;">
    <tr>
        <td style="width: 50mm; height: 65mm; border-bottom: black 1.5px solid;">
            <table style="width: 50mm; height: 100%;" cellspacing="0">
                <tr><td class="kassir" style="vertical-align: top; letter-spacing: 0.2em;">Извещение</td></tr>
                <tr><td class="kassir" style="vertical-align: bottom;">Кассир</td></tr>
            </table>
        </td>
        <td style="width: 130mm; height: 65mm; padding: 0mm 4mm 0mm 3mm; border-left: black 1.5px solid; border-bottom: black 1.5px solid;">
            <table cellspacing="0" align="center" style="width: 123mm; height: 100%"><tr><td>
            <table width="100%" cellspacing="0"><tr><td style="height: 5mm;"></td>
            <td class="stext7" style="text-align: right; vertical-align: middle;"><i>Форма &#8470; ПД-4</i>
            </td></tr></table></td></tr><tr><td><table style="width: 100%; height: 100%;" cellspacing="0">
            <tr><td class="string"><?php echo $sbrf['config']['SBRF_SHOP']['value']; ?></td></tr></table></td></tr>
            <tr><td class="subscript nowr">(наименование получателя платежа)</td></tr>
            <tr><td><table cellspacing="0" width="100%"><tr><td width="30%" class="floor">
            <table class="cells" cellspacing="0"><tr>
				<?php for ($i=0; $i<12; $i++){ ?>
                    <td class="cell" style="width: 8%;"><?php echo substr($sbrf['config']['SBRF_SHOP_INN']['value'], $i, 1); ?></td>
				<?php } ?>
            </tr></table></td><td width="10%" class="stext7">&nbsp;</td><td width="60%" class="floor">
            <table class="cells" cellspacing="0"><tr>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][0]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][1]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][2]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][3]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][4]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][5]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][6]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][7]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][8]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][9]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][10]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][11]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][12]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][13]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][14]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][15]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][16]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][17]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][18]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][19]; ?></td>
              </tr></table></td></tr><tr><td class="subscript nowr">(ИНН получателя платежа)</td>
              <td class="subscript">&nbsp;</td><td class="subscript nowr">(номер счета получателя платежа)</td>
              </tr></table></td></tr><tr><td><table cellspacing="0" width="100%"><tr>
              <td width="2%" class="stext">в</td><td width="64%" class="string"><?php echo $sbrf['config']['SBRF_SHOP_BANK']['value']; ?></td>
              <td width="7%" class="stext" align="right">БИК&nbsp;</td>
              <td width="27%" class="floor"><table class="cells" cellspacing="0"><tr>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][0]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][1]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][2]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][3]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][4]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][5]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][6]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][7]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][8]; ?></td>
              </tr></table></td></tr><tr><td class="subscript">&nbsp;</td><td class="subscript nowr">(наименование банка получателя платежа)</td></tr></table></td></tr><tr><td><table cellspacing="0" width="100%"><tr>
              <td class="stext7 nowr" width="40%">Номер кор./сч. банка получателя платежа</td>
              <td width="60%" class="floor"><table class="cells" cellspacing="0"><tr>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][0]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][1]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][2]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][3]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][4]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][5]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][6]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][7]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][8]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][9]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][10]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][11]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][12]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][13]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][14]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][15]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][16]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][17]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][18]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][19]; ?></td>
              </tr></table></td></tr></table></td></tr><tr><td><table cellspacing="0" width="100%"><tr>
              <td class="string" width="55%"><?php echo $order['title']; ?></td><td class="stext7" width="5%">&nbsp;</td><td class="string" width="40%">&nbsp;</td></tr><tr>
              <td class="subscript nowr">(наименование платежа)</td><td class="subscript">&nbsp;</td><td class="subscript nowr">(номер лицевого счета (код) плательщика)</td></tr></table>
              </td></tr><tr><td>
              <table cellspacing="0" width="100%"><tr>
              <td class="stext" width="1%">Ф.И.О&nbsp;плательщика&nbsp;</td><td class="string"><?php echo $order['customer_name']; ?></td></tr></table></td></tr>
              <tr><td><table cellspacing="0" width="100%"><tr><td class="stext" width="1%">Адрес&nbsp;плательщика&nbsp;</td><td class="string"><?php echo $order['customer_address']; ?></td></tr></table></td></tr><tr><td>
              <table cellspacing="0" width="100%"><tr><td class="stext" width="1%">Сумма&nbsp;платежа&nbsp;</td><td class="string" width="8%"><?php echo $order['summ_parts'][0]; ?></td><td class="stext" width="1%">&nbsp;руб.&nbsp;</td><td class="string" width="8%"><?php echo $order['summ_parts'][1]; ?></td><td class="stext" width="1%">&nbsp;коп.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Сумма&nbsp;платы&nbsp;за&nbsp;услуги&nbsp;</td><td class="string" width="8%">&nbsp;</td><td class="stext" width="1%">&nbsp;руб.&nbsp;</td><td class="string" width="8%">&nbsp;</td><td class="stext" width="1%">&nbsp;коп.</td></tr></table></td></tr><tr><td><table cellspacing="0" width="100%"><tr>
              <td class="stext" width="5%">Итого&nbsp;</td><td class="string" width="8%">&nbsp;</td><td class="stext" width="5%">&nbsp;руб.&nbsp;</td><td class="string" width="8%">&nbsp;</td><td class="stext" width="5%">&nbsp;коп.&nbsp;</td>
              <td class="stext" width="20%" align="right">&laquo;&nbsp;</td><td class="string" width="8%"><?php echo date('d'); ?></td><td class="stext" width="1%">&nbsp;&raquo;&nbsp;</td>
              <td class="string" width="20%"><?php echo $month; ?></td><td class="stext" width="3%">&nbsp;<?php echo date('Y'); ?></td>
              <td class="stext" width="1%">&nbsp;г.</td></tr></table></td></tr><tr><td class="stext7" style="text-align: justify">С условиями приема указанной в платежном документе суммы, в т.ч. с суммой взимаемой платы за&nbsp;услуги банка,&nbsp;ознакомлен&nbsp;и&nbsp;согласен.</td></tr><tr><td style="padding-bottom: 0.5mm;"><table cellspacing="0" width="100%"><tr><td class="stext7" width="50%">&nbsp;</td><td class="stext7" width="1%"><b>Подпись&nbsp;плательщика&nbsp;</b></td><td class="string" width="40%">&nbsp;</td></tr></table></td></tr></table>
        </td>
    </tr>
    <tr>
        <td style="width: 50mm; height: 80mm; vertical-align: bottom;" class="kassir">Квитанция<br><br>Кассир</td>
        <td style="width: 130mm; height: 80mm; padding: 0mm 4mm 0mm 3mm; border-left: black 1.5px solid;">

            <table cellspacing="0" align="center" style="width: 123mm; height: 100%"><tr><td><table style="width: 100%; height: 100%;" cellspacing="0">
            <tr><td class="string"><?php echo $sbrf['config']['SBRF_SHOP']['value']; ?></td></tr></table></td></tr>
            <tr><td class="subscript nowr">(наименование получателя платежа)</td></tr>
            <tr><td><table cellspacing="0" width="100%"><tr><td width="30%" class="floor">
            <table class="cells" cellspacing="0"><tr>
					<?php for ($i=0; $i<12; $i++){ ?>
		                <td class="cell" style="width: 8%;"><?php echo substr($sbrf['config']['SBRF_SHOP_INN']['value'], $i, 1); ?></td>
					<?php } ?>
            </tr></table></td><td width="10%" class="stext7">&nbsp;</td><td width="60%" class="floor">
            <table class="cells" cellspacing="0"><tr>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][0]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][1]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][2]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][3]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][4]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][5]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][6]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][7]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][8]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][9]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][10]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][11]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][12]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][13]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][14]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][15]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][16]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][17]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][18]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_ACC']['value'][19]; ?></td>
              </tr></table></td></tr><tr><td class="subscript nowr">(ИНН получателя платежа)</td>
              <td class="subscript">&nbsp;</td><td class="subscript nowr">(номер счета получателя платежа)</td>
              </tr></table></td></tr><tr><td><table cellspacing="0" width="100%"><tr>
              <td width="2%" class="stext">в</td><td width="64%" class="string"><?php echo $sbrf['config']['SBRF_SHOP_BANK']['value']; ?></td>
              <td width="7%" class="stext" align="right">БИК&nbsp;</td>
              <td width="27%" class="floor"><table class="cells" cellspacing="0"><tr>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][0]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][1]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][2]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][3]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][4]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][5]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][6]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][7]; ?></td>
                    <td class="cell" style="width: 11%;"><?php echo $sbrf['config']['SBRF_SHOP_BIK']['value'][8]; ?></td>
              </tr></table></td></tr><tr><td class="subscript">&nbsp;</td><td class="subscript nowr">(наименование банка получателя платежа)</td></tr></table></td></tr><tr><td><table cellspacing="0" width="100%"><tr>
              <td class="stext7 nowr" width="40%">Номер кор./сч. банка получателя платежа</td>
              <td width="60%" class="floor"><table class="cells" cellspacing="0"><tr>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][0]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][1]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][2]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][3]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][4]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][5]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][6]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][7]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][8]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][9]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][10]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][11]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][12]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][13]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][14]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][15]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][16]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][17]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][18]; ?></td>
                    <td class="cell" style="width: 5%;"><?php echo $sbrf['config']['SBRF_SHOP_KS']['value'][19]; ?></td>
              </tr></table></td></tr></table></td></tr><tr><td><table cellspacing="0" width="100%"><tr>
              <td class="string" width="55%"><?php echo $order['title']; ?></td><td class="stext7" width="5%">&nbsp;</td><td class="string" width="40%">&nbsp;</td></tr><tr>
              <td class="subscript nowr">(наименование платежа)</td><td class="subscript">&nbsp;</td><td class="subscript nowr">(номер лицевого счета (код) плательщика)</td></tr></table>
              </td></tr><tr><td>
              <table cellspacing="0" width="100%"><tr>
              <td class="stext" width="1%">Ф.И.О&nbsp;плательщика&nbsp;</td><td class="string"><?php echo $order['customer_name']; ?></td></tr></table></td></tr>
              <tr><td><table cellspacing="0" width="100%"><tr><td class="stext" width="1%">Адрес&nbsp;плательщика&nbsp;</td><td class="string"><?php echo $order['customer_address']; ?></td></tr></table></td></tr><tr><td>
              <table cellspacing="0" width="100%"><tr><td class="stext" width="1%">Сумма&nbsp;платежа&nbsp;</td><td class="string" width="8%"><?php echo $order['summ_parts'][0]; ?></td><td class="stext" width="1%">&nbsp;руб.&nbsp;</td><td class="string" width="8%"><?php echo $order['summ_parts'][1]; ?></td><td class="stext" width="1%">&nbsp;коп.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Сумма&nbsp;платы&nbsp;за&nbsp;услуги&nbsp;</td><td class="string" width="8%">&nbsp;</td><td class="stext" width="1%">&nbsp;руб.&nbsp;</td><td class="string" width="8%">&nbsp;</td><td class="stext" width="1%">&nbsp;коп.</td></tr></table></td></tr><tr><td><table cellspacing="0" width="100%"><tr>
              <td class="stext" width="5%">Итого&nbsp;</td><td class="string" width="8%">&nbsp;</td><td class="stext" width="5%">&nbsp;руб.&nbsp;</td><td class="string" width="8%">&nbsp;</td><td class="stext" width="5%">&nbsp;коп.&nbsp;</td>
              <td class="stext" width="20%" align="right">&laquo;&nbsp;</td><td class="string" width="8%"><?php echo date('d'); ?></td><td class="stext" width="1%">&nbsp;&raquo;&nbsp;</td>
              <td class="string" width="20%"><?php echo $month; ?></td><td class="stext" width="3%">&nbsp;<?php echo date('Y'); ?></td>
              <td class="stext" width="1%">&nbsp;г.</td></tr></table></td></tr><tr><td class="stext7" style="text-align: justify">С условиями приема указанной в платежном документе суммы, в т.ч. с суммой взимаемой платы за&nbsp;услуги банка,&nbsp;ознакомлен&nbsp;и&nbsp;согласен.</td></tr><tr><td style="padding-bottom: 0.5mm;"><table cellspacing="0" width="100%"><tr><td class="stext7" width="50%">&nbsp;</td><td class="stext7" width="1%"><b>Подпись&nbsp;плательщика&nbsp;</b></td><td class="string" width="40%">&nbsp;</td></tr></table></td></tr></table>


        </td>
    </tr>
</table>

    </body>

</html>
