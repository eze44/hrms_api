<div>
    <p>Dear {{ $name }},</p>

    <p>We want to inform you, that your monthly payroll has been submitted to the bank.</p>
    @if($bonus != 0)
        <p>For this month, your bonus is {{ $bonus }}</p>
    @endif
    <p>Thank you for your <strong>amazing</strong> work in our company.</p>
</div>
