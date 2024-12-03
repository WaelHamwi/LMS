<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\RegisterForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\PendingUser;
use Illuminate\Support\Str;


#[Layout('layouts.app')]
class RegisterComponent extends Component
{
    public RegisterForm $form;
    public $verificationMessage;
    public function mount()
    {
        $this->form = new RegisterForm($this, []);
    }

    public function register()
    {
        try {
            $this->validate([
                'form.name' => 'required|string|max:255',
                'form.email' => 'required|email|unique:users,email|unique:pending_users,email', // here we Validate uniqueness across both tables
                'form.password' => 'required|string|min:8|same:form.password_confirmation',
                'form.password_confirmation' => 'required|string|min:8',
            ]);

            $verificationToken = Str::random(64);

            PendingUser::create([
                'name' => $this->form->name,
                'email' => $this->form->email,
                'password' => Hash::make($this->form->password),
                'verification_token' => $verificationToken,
            ]);

            $this->verificationMessage = 'A verification email has been sent. Please check your inbox.';
            session()->flash('email', $this->form->email);
            return redirect()->route('login')->with('verificationMessage', $this->verificationMessage);
        } catch (\Exception $e) {
            session()->flash('error', 'There was an issue during registration. ' . $e->getMessage());
            $this->reset();

            return redirect()->route('register');
        }
    }

    public function sendVerificationEmail($email, $token, $name)
    {
        $verificationUrl = route('verify.email', ['token' => $token]);

        Mail::send('emails.verify-email', [
            'verificationUrl' => $verificationUrl,
            'name' => $name 
        ], function ($message) use ($email) {
            $message->to($email)
                ->subject('Verify Your Email Address');
        });
    }




    public function render()
    {
        return view('livewire.pages.auth.register');
    }
}
