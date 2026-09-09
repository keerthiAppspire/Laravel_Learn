<?php
use App\Services\PayrollAuditExport;
use App\Services\HeadcountExport;
use Illuminate\Support\Facades\Storage;

test('Payroll audit uses hr-private disk', function () {
    Storage::fake('hr-private');
    Storage::fake('exports');
    $payroll = app(PayrollAuditExport::class);
    $payroll->export();
    Storage::disk('hr-private')->assertExists('payroll_audit.txt');
    Storage::disk('exports')->assertMissing('payroll_audit.txt');
});
test('Headcount export uses exports disk', function () {
    Storage::fake('hr-private');
    Storage::fake('exports');
    $headcount = app(HeadcountExport::class);
    $headcount->export();
    Storage::disk('exports')->assertExists('headcount.txt');
    Storage::disk('hr-private')->assertMissing('headcount.txt');
});