<div class="alt-three-column">
  <div class="sub-news-headline">Booking Agents: Agency websites</div>
    <div class="three-column-23">
      <div id="agentswebsites" class="data-tab-content table-pagination">
                    <table>
                        <thead>
                            <tr>
                                <?php if(logged_in() == true) { ?>
                                <th>Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_records('default', $conn, 'agentswebsites');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
      </div>
   </div>
</div>
