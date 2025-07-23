<?php

namespace App\Livewire\Users;

use App\Helpers\UserHelper;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportPage extends Component
{
    use WithFileUploads;

    public $file;
    public $users = [];
    public $showPreview = false;

    protected $rules = [
        'file' => 'required|file|mimes:xlsx,xls,csv',
    ];

    /**
     * @return void
     */
    public function mount(): void
    {
        if (!UserHelper::isAdministrator()) {
            abort(403);
        }
    }

    /**
     * @return void
     */
    public function uploadFile(): void
    {
        $this->validate();

        try {
            $import = new UsersImport();
            $result = Excel::import($import, $this->file);

            $this->users = $import->getUsers();

            if (empty($this->users)) {
                session()?->flash('error', 'Aucun utilisateur trouvé dans le fichier.');
                return;
            }

            $this->showPreview = true;
        } catch (\Exception $e) {
            session()?->flash('error', 'Une erreur est survenue lors de l\'importation du fichier: ' . $e->getMessage());
        }
    }

    /**
     * @param int $index
     * @return void
     */
    public function removeUser(int $index): void
    {
        unset($this->users[$index]);
        $this->users = array_values($this->users);
    }

    /**
     * @return RedirectResponse|Redirector
     */
    public function createUsers(): RedirectResponse|Redirector
    {
        foreach ($this->users as $userData) {
            User::create([
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'email' => $userData['email'],
                'role' => $userData['role'],
                'organization_id' => auth()->user()->organization_id,
                'password' => Hash::make('password'),
            ]);
        }

        session()->flash('message', 'Les utilisateurs ont été créés avec succès.');
        return redirect()->route('users.index');
    }

    public function render(): View
    {
        return view('livewire.users.import-page');
    }
}
