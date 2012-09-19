<?php
session_start();
include("../include/database.php");
$party_id = $_GET['party_id'];
$products = $database->getProduct();
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addTable tr:odd").addClass("alt");
        $("#addTable tr:even").addClass("alt2");
    });
</script>

<div class="tableContainer" id="tableContainer">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" id="addTable">
        <tbody  class="scrollContent" id="scrollContent">
            <tr  class="alternateRow">
                <th width="35px" colspan="1" rowspan="2" >S.N.
                </th>
                <th width="134px" colspan="1" rowspan="2" >Product
                </th>
                <th class="altTh" colspan="2" rowspan="1" >Stock
                </th>
                <th class="altTh" colspan="2" rowspan="1" >Plan
                </th>
                <th class="altTh" colspan="2" rowspan="1" >Discount
                </th>
            </tr>
            <tr class="normalRow">
                <th class='altTr'>case
                </th>
                <th class='altTr'>pcs
                </th>
                <th class='altTr'>case
                </th>
                <th class='altTr'>pcs
                </th>
                <th class='altTr'>case
                </th>
                <th class='altTr'>pcs
                </th>
            </tr>
        </tbody>
        <tbody  class="scrollContent">
            <?php
            $i = 1;
            $html = '';
            foreach ($products as $count => $product) {
                $html .= '<tr>
                <td width="35px">' . $i++ . '
                </td>

                <td width="135px">' . $product['name'] . " " . $product['quantity'] . " " . $product['unit_name'] . '<input type="hidden" name="product_id' . $count . '" value="' . $product["id"] . '">
                </td>';

                $stock = $database->getPartyStock($party_id, $product['id']);
                if (is_array($stock) && count($stock)) {
                    $html.= "<td class='altTr'>" . $stock[0]['no_of_case'] . "</td>";
                    $html.="<td class='altTr'>" . $stock[0]['indivisual'] . "</td>";
                } else {
                    $html .= "<td class='altTr'>0</td><td class='altTr'>0</td>";
                }

                $html.=<<<EOT
                <td class="altTr"><input type="text" name=plan_case{$count} size="3" />
                </td>

                <td class="altTr"><input type="text" name=plan_individual{$count} size="3" />
                </td>

                <td class="altTr"><input type="text" name=discount_case{$count} size="3" />
                </td>

                <td class="altTr"><input type="text" name=discount_case{$count} size="3" />
                </td>
            </tr>
EOT;
            }
            $html.=<<<EOT
                </tbody>
    </table><div><input type="hidden" name="add"><input type="hidden" name="count" value="{$count}" /></div>
EOT;
            echo $html;
            ?>
            </div>
