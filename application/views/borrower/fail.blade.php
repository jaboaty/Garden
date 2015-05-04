<p>Please Enter A Borrower Id</p>

<?php
    echo Form::open_for_files('/borrowers', 'PUT');

    echo Form::label('borrower_id', 'What is the borrowers ID number?');
    echo Form::text('borrower_id');
    echo Form::submit('Add Borrower');
    echo Form::close();

?>