<?php

namespace App\Livewire\Users;

use App\Exports\UsersImportTemplate;
use Illuminate\View\View;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Import extends Component
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @return BinaryFileResponse
     */
    public function downloadTemplate(): BinaryFileResponse
    {
        return Excel::download(new UsersImportTemplate, 'users_import_template.xlsx');
    }

    public function render(): View
    {
        return view('livewire.users.import');
    }
}
