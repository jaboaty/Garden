@forelse ($borrowers as $borrower)
    

    <div class="well clearfix">
    	<img class="pull-left img-polaroid" style="margin-right:6px;" src="http://s3-1.kiva.org/img/s232/{{ $borrower->image }}.jpg" />

		<h4>{{ $borrower->name }}</h4>
		<p>
			<strong>Location:</strong>
			<?php
			if ( $borrower->town != '' ) {
				echo $borrower->town.",&nbsp;";
			}
			?>
			{{$borrower->country}}
			&nbsp;&nbsp;&nbsp;&nbsp;
			<p><strong>Activity: </strong>{{$borrower->sector}}&nbsp;|&nbsp;{{$borrower->activity}}</p>

			<p><strong>Use: </strong>{{$borrower->use}}</p>


			<p><strong>Funds Raised: </strong>{{$borrower->funded_amount}}&nbsp;/&nbsp;{{$borrower->loan_amount}}</p>

			<p>
				@forelse ($borrower->lenders as $lender)

					<?php if(isset($lender->image)):?>
					<img class="pull-left img-polaroid" style="margin-right:3px; margin-bottom:3px; max-height:32px; width:auto;" src="http://s3-2.kiva.org/img/w800/{{ $lender->image }}.jpg" />
					<?php endif; ?>

				@empty
				    There are no lenders yet
				@endforelse

			</p>

			<p class="clearfix">
				<?php 
				    echo Form::open_for_files('/borrowers', 'DELETE');
				    echo Form::hidden('id', $borrower->id);
				    echo Form::submit('Remove Borrower',array('class' => 'btn btn-warning'));
				    echo Form::close();
				?>
			</p>


		</p>
    </div>
    <br /><br />
@empty
    There are not posts in the array!
@endforelse

