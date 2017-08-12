{* template block that contains the new field *}
<div id="membership-start-end-tr" class="membership-terms-date-container">
    {if $records}
        <ul>
            {foreach from=$records key=k item=rec}
                <li>Term/Period {$k+1}: {$rec.start_date} - {$rec.end_date}</li>
            {/foreach}
        </ul>
    {/if}

    {if $form.starting_date}
        <div>Membership Starting Date:</div>
        <div>{$form.starting_date.html}</div>

        <div>Membership Ending Date:</div>
        <div>{$form.ending_date.html}</div>
    {/if}
</div>
{* reposition the above block after #someOtherBlock *}
<script type="text/javascript">

    if (jQuery('.crm-membershiprenew-form-block-contribution_status_id').length)
        cj('#membership-start-end-tr').insertAfter('.crm-membershiprenew-form-block-contribution_status_id');
    else if (jQuery('.crm-summary-contactinfo-block').length) // if its Contact page
        cj('#membership-start-end-tr').insertBefore('.crm-summary-contactinfo-block');
    else
        cj('#membership-start-end-tr').insertAfter('.crm-membership-form-block-end_date');
</script>