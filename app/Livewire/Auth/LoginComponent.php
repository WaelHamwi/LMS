<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PendingUser;
use Illuminate\Support\Facades\Log;
use App\Livewire\Auth\RegisterComponent;
use App\Http\Traits\AuthTrait;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.app')]
class LoginComponent extends Component
{
    use AuthTrait;
    public LoginForm $form;
    public $verificationMessage;
    public $role;

    public function mount()
    {
        $this->role = request()->query('role');
        $this->form = new LoginForm($this, []);
        if (session()->has('email')) {
            $this->form->email = session('email');
        }
    }

    public function login()
    {
        try {
            $this->validateCommonFields();

            $user = match ($this->role) {
                'admin' => $this->authenticateAdmin($this->form->email, $this->form->password),
                'student' => $this->authenticateStudent($this->form->email, $this->form->password),
                'parent' => $this->authenticateParent($this->form->email, $this->form->password),
                'teacher' => $this->authenticateTeacher($this->form->email, $this->form->password),
                default => throw new \Exception("Invalid role specified."),
            };


            Session::regenerate();

            $this->form->authenticate($this->role);

            $guard = $this->checkGuard($this->role);
            return $this->roleRedirect($guard);
        } catch (\Exception $e) {
            session()->flash('error', 'There was an issue during login: ' . $e->getMessage());
            $this->reset();
            return redirect(route('roles'));
        }
    }

    public function resendVerificationEmail()
    {
        try {
            Log::info('Attempting to resend verification email.');
            $pendingUser = PendingUser::where('email', $this->form->email)->first();

            if ($pendingUser) {
                Log::info('Pending user found: ' . $pendingUser->email);

                $registerComponent = new RegisterComponent();
                $registerComponent->sendVerificationEmail(
                    $pendingUser->email,
                    $pendingUser->verification_token,
                    $pendingUser->name
                );

                $this->verificationMessage = 'A new verification email has been sent. Please check your inbox.';
                return redirect()->route('login');
            } else {
                Log::info('No pending user found with email: ' . $this->form->email);
                $this->verificationMessage = 'No pending user found with this email.';
            }
        } catch (\Exception $e) {
            Log::error('Error resending verification email: ' . $e->getMessage());
            session()->flash('error', 'There was an issue while resending the verification email: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pages.auth.login');
    }

    // Authentication methods for different roles
    public function authenticateAdmin($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            throw new \Exception("Invalid admin credentials.");
        }
        return $user;
    }

    public function authenticateStudent($email, $password)
    {

        $student = Student::where('email', $email)->first();
        if (!$student || !Hash::check($password, $student->password)) {
            throw new \Exception("Invalid student credentials.");
        }
        return $student;
    }

    public function authenticateParent($email, $password)
    {
        $parent = StudentParent::where('email', $email)->first();
        if (!$parent || !Hash::check($password, $parent->password)) {
            throw new \Exception("Invalid parent credentials.");
        }
        return $parent;
    }

    public function authenticateTeacher($email, $password)
    {   
        $teacher = Teacher::where('email', $email)->first();
        if (!$teacher || !Hash::check($password, $teacher->password)) {
            throw new \Exception("Invalid teacher credentials.");
        }

        return $teacher;
    }


    protected function validateCommonFields()
    {
        $this->validate([
            'form.email' => 'required|email',
            'form.password' => 'required|string',
        ]);
    }
}
