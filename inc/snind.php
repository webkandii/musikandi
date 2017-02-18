<div class="alt-three-column">
<div class="sub-news-box"><div class="sub-news-headline">What's up..</div>
<div class="sub-news-headline">Booking Agents: Agency websites</div>

<!-- PIC -->

	<div class="three-column-1"><div class="news-column-1">
<div class="news-pic-wrap"><!-- image can go here --></div>
	
	</div></div>

<!-- NEWS -->

<div class="three-column-23">
<div id="booking-agents" class="data-tab-content active table-pagination">
                    <h2>Agents Websites</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Website</th>
                                 <?php if(logged_in() == true) { ?>
                                <th>Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_records('default', $conn, 'agents-websites');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
</div>

</div>

</div>
</div>
