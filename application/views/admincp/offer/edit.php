<div class="main_area">
    <div class="breakcrumb">
        <table border="0">
            <tbody>
            <tr>
                <td width="25">
                    <i class="fa icon-23 fa-windows"></i>
                </td>
                <td> Quản lý nội dung / coder voucher / <?php echo $map_title ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="content">
    <div class="content_i">
        <form method="post" name="add-new" action="" enctype="multipart/form-data">

            <table>
                <tr>
                    <td class = 'title_td' width="200">Chương trình khuyến mãi</td>
                    <td>
                        <?php echo $info['coupon_code']?>

                    </td>
                </tr>
                <tr>
                    <td class = 'title_td' width="200">Áp dụng cho</td>
                    <td>
                        <?php
                            if($info['card_type'] == 1) {
                                echo 'Tất cả';
                            } else if($info['card_type'] == 3) {
                                echo 'Danh mục sản phẩm';
                            } else if($info['card_type'] == 5) {
                                echo 'Sản phẩm';
                            }
                        ?>

                    </td>
                </tr>
                <?php if($info['card_type'] == 3){
                    $query = $this->db->query("SELECT * FROM `offer_product` WHERE `offer_id` = ".$info['id']);
                    $data = $query->result_array();
                    ?>
                <tr>
                    <td class = 'title_td' width="200">Danh mục sản phẩm</td>
                    <td>
                        <?php
                            if(!empty($data)) {
                                foreach ($data as $value) {
                                    $catalog = $this->catelog_model->get_list(array('Id'=>$value['catagory_id']));
                                    echo $catalog[0]['title_vn'].'<br>';
                                }
                            }
                        ?>
                    </td>
                </tr>
                <?php } ?>
                <?php if($info['card_type'] == 5){
                    $query = $this->db->query("SELECT * FROM `offer_product` WHERE `offer_id` = ".$info['id']);
                    $data = $query->result_array();
                    ?>
                    <tr>
                        <td class = 'title_td' width="200">Sản phẩm</td>
                        <td>
                            <?php
                            if(!empty($data)) {
                                foreach ($data as $value) {
                                    $product = $this->product_model->get_Id($value['product_id']);
                                    echo $product[0]['title_vn'].'<br>';
                                }
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class = 'title_td' width="200">Giá trị giảm</td>
                    <td>
                        <?php
                        if($info['discount_unit'] == 1) {
                           echo 'Giảm '. $info['discount_value'].' VND';
                        } else if($info['discount_unit'] == 3) {
                            echo 'Giảm '. $info['discount_value'].' %';
                        } else if($info['discount_unit'] == 5) {
                            echo 'Đồng giá '. $info['discount_value'].' VND';
                        }
                        ?>

                    </td>
                </tr>
                <tr>
                    <td class = 'title_td' width="200">Bắt đầu khuyến mãi</td>
                    <td>
                        <?php echo date('d-m-Y', $info['valid_from']) ?>

                    </td>
                </tr>
                <tr>
                    <td class = 'title_td' width="200">Kết thúc khuyến mãi</td>
                    <td>
                        <?php echo date('d-m-Y', $info['valid_until']) ?>

                    </td>
                </tr>
<!--                <tr>-->
<!--                    <td class = 'title_td' width="200">Trạng thái</td>-->
<!--                    <td>-->
<!--                        --><?php //if($info['active']==0){echo "Áp dụng";} else echo 'Ngưng'; ?>
<!---->
<!--                    </td>-->
<!--                </tr>-->

            </table>
        </form>
    </div>
</div>