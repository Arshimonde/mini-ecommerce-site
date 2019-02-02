<!-- DISPLAY PRODUCTS -->
<div class="container-fluid px-4">
    <table class="table table-striped table-sm">
        <thead >
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Company name</th>
                <th>Address</th>
                <th>City</th>
                <th>Country</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $clients = db_select("client","*");
            ?>
            <!-- Product row start -->
            <?php foreach($clients as $client):?>
            <tr>
              <td class="align-middle">
                <?= $client["first_name"] ?>
              </td>

              <td class="align-middle">
                <?= $client["last_name"] ?>
              </td>
              <td class="align-middle">
                 <?= $client["company_name"] ?>
              </td>
              <td class="align-middle">
                 <?= $client["address"] ?>
              </td>
              <td class="align-middle">
                <?= $client["city"] ?>
              </td>
              <td class="align-middle">
                <?= $client["country"] ?>
              </td>
              <td class="align-middle">
                <?= $client["phone"] ?>
              </td>
            </tr>
            <?php endforeach;?>
            <!-- Product row end -->
        </tbody>
    </table>
</div>