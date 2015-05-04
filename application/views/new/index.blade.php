@forelse ($data['loans'] as $borrower)
    

    <div class="well clearfix">
    	<img class="pull-left img-polaroid" style="margin-right:6px;" src="http://s3-1.kiva.org/img/s232/{{ $borrower['image']['id'] }}.jpg" />

		<h4>{{ $borrower['name'] }}</h4>
		<p>
			<strong>Location:</strong>
			<?php
			if (array_key_exists('town', $borrower['location'])) {
				echo $borrower['location']['town'].",&nbsp;";
			}
			?>
			{{$borrower['location']['country']}}
			&nbsp;&nbsp;&nbsp;&nbsp;
			<p><strong>Activity: </strong>{{$borrower['sector']}}&nbsp;|&nbsp;{{$borrower['activity']}}</p>

			<p><strong>Use: </strong>{{$borrower['use']}}</p>


			<p><strong>Funds Raised: </strong>{{$borrower['funded_amount']}}&nbsp;/&nbsp;{{$borrower['loan_amount']}}</p>



			<?php if (in_array($borrower['id'], $current_borrowers)) : ?>
				<p><strong>Already Tracking This Project</strong></p>
			<?php else: ?>
				<?php
				    echo Form::open_for_files('/borrowers', 'PUT');
				    echo Form::hidden('borrower_id', $borrower['id']);
				    echo Form::submit('Add Borrower',array('class' => 'btn btn-success'));
				    echo Form::close();
				?>
			<?php endif; ?>

		</p>
    </div>
    <br /><br />
@empty
    There are not posts in the array!
@endforelse

