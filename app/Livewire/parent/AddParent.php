<?php

namespace App\Livewire\parent;

use Livewire\Component;
use App\Models\Blood;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\StudentParent;
use App\Models\Attachment;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
//use Illuminate\Support\Facades\Storage;

class AddParent extends Component
{
    use WithFileUploads;
    public $step = 1;
    public $handleErrors = [];
    public $father_name;
    public $father_national_id;
    public $father_passport_id;
    public $father_phone;
    public $father_job;
    public $father_nationality_id;
    public $father_blood_id;
    public $father_religion_id;

    public $nationalities;
    public $bloods;
    public $religions;
    public $formValidated = false;

    // Mother Properties (Add these)
    public $mother_name;
    public $mother_national_id;
    public $mother_passport_id;
    public $mother_phone;
    public $mother_job;
    public $mother_nationality_id;
    public $mother_blood_id;
    public $mother_religion_id;

    public $email;
    public $password;
    public $password_confirmation;
    public $confirmMessage = 'Are you sure you want to save the parent details?';
    public $showCard = false;
    public $files = [];
    public $loading = false;
    public $showingTable = true;
    public $studentParents;
    public $selectedStudentParentId;
    public $showDeleteConfirmationModal = false;
    public $selectedId;
    public $selectedEmail;
    public $updateMode;


    protected function fileRules()
    {
        return ['files.*' => 'file|mimes:jpg,png,pdf|max:2048|nullable'];
    }
    protected function fatherRules()
    {
        $rules = [
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'father_name' => 'required|string|max:255',
            'father_national_id' => 'required|numeric',
            'father_passport_id' => 'nullable|numeric',
            'father_phone' => 'required|numeric',
            'father_job' => 'required|string|max:255',
            'father_nationality_id' => 'required|exists:nationalities,id',
            'father_blood_id' => 'required|exists:bloods,id',
            'father_religion_id' => 'required|exists:religions,id',
        ];

        if ($this->updateMode) {
            $rules['email'] = [
                'required',
                'email',
                'unique:student_parents,email,' . $this->selectedStudentParentId,
            ];

            $rules['password'] = 'nullable|string|min:8|confirmed';
            $rules['password_confirmation'] = 'nullable|string|min:8';
        } else {
            $rules['email'] = 'required|email|unique:student_parents,email';
        }
        return $rules;
    }


    protected function motherRules()
    {
        return [
            'mother_name' => 'required|string|max:255',
            'mother_national_id' => 'required|numeric',
            'mother_passport_id' => 'nullable|numeric',
            'mother_phone' => 'required|numeric',
            'mother_job' => 'required|string|max:255',
            'mother_nationality_id' => 'required|exists:nationalities,id',
            'mother_blood_id' => 'required|exists:bloods,id',
            'mother_religion_id' => 'required|exists:religions,id',
        ];
    }

    public function mount($studentParent = null)
    {
        $this->nationalities = Nationality::all();
        $this->bloods = Blood::all();
        $this->religions = Religion::all();
        $this->studentParents = StudentParent::all();
        $this->updateMode = false;



        if ($studentParent) {
            $this->updateMode = true;
            $this->selectedStudentParentId = $studentParent->id;


            $this->father_name = $studentParent->father_name;
            $this->father_national_id = $studentParent->father_national_id;
            $this->father_passport_id = $studentParent->father_passport_id;
            $this->father_phone = $studentParent->father_phone;
            $this->father_job = $studentParent->father_job;
            $this->father_nationality_id = $studentParent->father_nationality_id;
            $this->father_blood_id = $studentParent->father_blood_id;
            $this->father_religion_id = $studentParent->father_religion_id;


            $this->mother_name = $studentParent->mother_name;
            $this->mother_national_id = $studentParent->mother_national_id;
            $this->mother_passport_id = $studentParent->mother_passport_id;
            $this->mother_phone = $studentParent->mother_phone;
            $this->mother_job = $studentParent->mother_job;
            $this->mother_nationality_id = $studentParent->mother_nationality_id;
            $this->mother_blood_id = $studentParent->mother_blood_id;
            $this->mother_religion_id = $studentParent->mother_religion_id;


            $this->email = $studentParent->email;
        }


        if (request()->query('updateMode')) {
            $this->updateMode = true;
        }
    }

    public function render()
    {
        return view('livewire.parent.add-parent', [
            'nationalities' => $this->nationalities,
            'bloods' => $this->bloods,
            'religions' => $this->religions,
        ]);
    }
    public function nextConfig()
    {
        $this->clearErrors();
        try {
            $this->validate($this->fileRules());
            if ($this->step === 1) {
                $this->validate($this->fatherRules());
                $this->step++;
            } elseif ($this->step === 2) {
                $this->validate($this->motherRules());
                $this->step++;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle each error for the specific keys
            foreach ($e->validator->errors()->getMessages() as $key => $messages) {
                $this->handleErrors[$key] = implode(', ', $messages);
            }
        }
    }

    public function nextTab()
    {
        $this->nextConfig();
    }

    public function clearErrors()
    {
        $this->handleErrors = [];
    }
    public function nextConfirm()
    {
        if ($this->validate()) {
            $this->step++;
        };
    }
    public function showConfirmationCard()
    {
        $this->showCard = true;
    }
    public function saveParents()
    {
        $this->validate(array_merge($this->fatherRules(), $this->motherRules()));

        try {
            $studentParent = new StudentParent();
            $studentParent->father_name = $this->father_name;
            $studentParent->father_national_id = $this->father_national_id;
            $studentParent->father_passport_id = $this->father_passport_id;
            $studentParent->father_phone = $this->father_phone;
            $studentParent->father_job = $this->father_job;
            $studentParent->father_nationality_id = $this->father_nationality_id;
            $studentParent->father_blood_id = $this->father_blood_id;
            $studentParent->father_religion_id = $this->father_religion_id;
            $studentParent->mother_name = $this->mother_name;
            $studentParent->mother_national_id = $this->mother_national_id;
            $studentParent->mother_passport_id = $this->mother_passport_id;
            $studentParent->mother_phone = $this->mother_phone;
            $studentParent->mother_job = $this->mother_job;
            $studentParent->mother_nationality_id = $this->mother_nationality_id;
            $studentParent->mother_blood_id = $this->mother_blood_id;
            $studentParent->mother_religion_id = $this->mother_religion_id;
            $studentParent->email = $this->email;
            $studentParent->password = bcrypt($this->password);

            $studentParent->save();
            if ($this->files) {
                $parentDir = strtolower(str_replace(' ', '_', $this->father_name));
                $passportIdDir = $this->father_passport_id;
                $storagePath = "parents'Attachments/$parentDir/$passportIdDir";

                foreach ($this->files as $file) {
                    $path = $file->store($storagePath);
                    $attachment = new Attachment();
                    $attachment->parent_id = $studentParent->id;
                    $attachment->file_path = $path;
                    $attachment->save();
                }
            }


            $this->reset();
            return redirect()->route('add_parent')->with('success', __('The parent details have been added successfully'));
        } catch (\Exception $e) {
            Log::error('Error saving parent details: ' . $e->getMessage());
            return redirect()->route('add_parent')->with('error', __('There was an error saving parent details.'));
        }
    }
    public function updateParents()
    {
        $this->validate(array_merge($this->fatherRules(), $this->motherRules()));

        try {
            $studentParent = StudentParent::findOrFail($this->selectedStudentParentId);
            $studentParent->father_name = $this->father_name;
            $studentParent->father_national_id = $this->father_national_id;
            $studentParent->father_passport_id = $this->father_passport_id;
            $studentParent->father_phone = $this->father_phone;
            $studentParent->father_job = $this->father_job;
            $studentParent->father_nationality_id = $this->father_nationality_id;
            $studentParent->father_blood_id = $this->father_blood_id;
            $studentParent->father_religion_id = $this->father_religion_id;
            $studentParent->mother_name = $this->mother_name;
            $studentParent->mother_national_id = $this->mother_national_id;
            $studentParent->mother_passport_id = $this->mother_passport_id;
            $studentParent->mother_phone = $this->mother_phone;
            $studentParent->mother_job = $this->mother_job;
            $studentParent->mother_nationality_id = $this->mother_nationality_id;
            $studentParent->mother_blood_id = $this->mother_blood_id;
            $studentParent->mother_religion_id = $this->mother_religion_id;
            $studentParent->email = $this->email;


            if ($this->password) {
                $studentParent->password = bcrypt($this->password);
            }

            $studentParent->save();

            if ($this->files) {
                $parentDir = strtolower(str_replace(' ', '_', $this->father_name));
                $passportIdDir = $this->father_passport_id;
                $storagePath = "parents'Attachments/$parentDir/$passportIdDir";

                foreach ($this->files as $file) {
                    $path = $file->store($storagePath);
                    $attachment = new Attachment();
                    $attachment->parent_id = $studentParent->id;
                    $attachment->file_path = $path;
                    $attachment->save();
                }
            }

            $this->reset();
            $this->showingTable=true;
            return redirect()->route('add_parent')->with('success', __('The parent details have been updated successfully'));
        } catch (\Exception $e) {
            Log::error('Error updating parent details: ' . $e->getMessage());
            return redirect()->route('add_parent')->with('error', __('There was an error updating parent details.'));
        }
    }


    public function previousTab()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }
    public function showTable()
    {
        $this->loading = true;
        $this->loading = false;
        $this->showingTable = !$this->showingTable;
    }

    public function selectStudentParent($id, $email)
    {
        $this->showDeleteConfirmationModal = true;
        $this->selectedId = $id;
        $this->selectedEmail = $email;
    }
    public function destroy($id)
    {
        $this->reset();

        try {
            $studentParent = StudentParent::find($id);

            if ($studentParent) {
                $studentParent->delete();
            }
            $this->showDeleteConfirmationModal = false;
            return redirect()->route('add_parent')->with('success', __('The parent details have been added successfully'));
        } catch (\Exception $e) {
            $this->showDeleteConfirmationModal = false;
            return redirect()->route('add_parent')->with('error', __('There was an error saving parent details.'));
        }
    }
    public function edit($id)
    {
        try {
            $this->showingTable = false;
            $studentParent = StudentParent::findOrFail($id);
            $this->mount($studentParent);
            $this->step = 1;
            $this->updateMode = true;
        } catch (\Exception $e) {
            $this->showDeleteConfirmationModal = false;
            return redirect()->route('add_parent')->with('error', __('There was an error activating update parent details.'));
        }
    }
}
