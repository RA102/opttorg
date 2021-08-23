<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="<?php echo date('); ?>">
    <shop>Y-m-d H:i'
        <name><?php echo $cfg['yml']['shop_name']; ?></name>
        <company><?php echo $cfg['yml']['shop_company']; ?></company>
        <url><?php echo $cfg['yml']['shop_url']; ?></url>

        <version>2.0</version>
        <agency>SanMarket</agency>
        <email>support@sanmarket.kz</email>

        <currencies>
            <currency id="<?php echo $cfg['yml']['base_curr']; ?>" rate="1"/>
            <?php foreach($cfg['yml']['curr'] as $c=>$kurs){ if ($c==$cfg['yml']['base_curr']) { continue; } ?>
                <currency id="<?php echo $c; ?>" rate="<?php echo $kurs; ?>"/>
            <?php } ?>
        </currencies>

        <categories>
            <?php $cat_ids = array(); ?>
            <?php foreach($cats as $cat){ ?>
                <?php $cat_ids[] = $cat['id']; ?>
                <category id="<?php echo $cat['id']; ?>"<?php if ($cat['parent_id']>1){ ?> parentId="<?php echo $cat['parent_id']; ?>"<?php } ?>><?php echo htmlspecialchars($cat['title']); ?></category>
            <?php } ?>
        </categories>

        <?php if ($cfg['yml']['ldc']){ ?>
            <local_delivery_cost><?php echo $cfg['yml']['ldc']; ?></local_delivery_cost>
        <?php } ?>

        <offers>

            <?php foreach($items as $i){ ?>
                <?php if (!in_array($i['category_id'], $cat_ids)){ continue; } ?>
                <offer id="<?php echo $i['id']; ?>" available="<?php if (!$cfg['track_qty'] || $i['qty']>0) { ?>true<?php } else { ?>false<?php } ?>">
                        <url><?php echo $cfg['yml']['shop_url'] ;?>shop/<?php echo $i['seolink']; ?>.html</url>
                        <price><?php echo $i['price']; ?></price>
                        <currencyId><?php echo $cfg['yml']['base_curr']; ?></currencyId>
                        <categoryId><?php echo $i['category_id']; ?></categoryId>
                        <picture><?php echo $cfg['yml']['shop_url'] ;?>images/photos/medium/<?php echo $i['filename']; ?></picture>
                        <?php if ($cfg['yml']['store'] != -1){ ?>
                            <store><?php echo $cfg['yml']['store'] ? 'true' : 'false'; ?></store>
                        <?php } ?>
                        <?php if ($cfg['yml']['pickup'] != -1){ ?>
                            <pickup><?php echo $cfg['yml']['pickup'] ? 'true' : 'false'; ?></pickup>
                        <?php } ?>
                        <?php if ($cfg['yml']['delivery'] != -1){ ?>
                            <delivery><?php echo $cfg['yml']['delivery'] ? 'true' : 'false'; ?></delivery>
                        <?php } ?>
                        <name><?php echo htmlspecialchars($i['title']); ?></name>
                        <?php if ($i['vendor']){ ?>
                            <vendor><?php echo htmlspecialchars($i['vendor']); ?></vendor>
                            <vendorCode><?php echo $i['vendor_id']; ?></vendorCode>
                        <?php } ?>
                        <?php if ($i['description']){ ?>
                            <description><?php echo htmlspecialchars(strip_tags($i['description'])); ?></description>
                        <?php } ?>
                </offer>
            <?php } ?>

        </offers>

    </shop>
</yml_catalog>
