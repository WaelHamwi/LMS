<?php

namespace App\Http\Livewire\parent;

use Livewire\Component;
use App\Models\StudentParent;
use Livewire\WithPagination;

class StudentParentManager extends Component
{
    use WithPagination;

    public $parents, $name, $email, $parentId;
    public $search = '';
    public $editMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:student_parents,email',
    ];

    public function render()
    {
        return view('livewire.parent.student-parent-manager');
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->parentId = null;
        $this->editMode = false;
    }

    public function save()
    {
        $this->validate();

        StudentParent::updateOrCreate(
            ['id' => $this->parentId],
            [
                'name' => $this->name,
                'email' => $this->email,
            ]
        );

        $this->resetFields();
        session()->flash('message', 'Parent saved successfully!');
    }

    public function edit($id)
    {
        $parent = StudentParent::findOrFail($id);
        $this->parentId = $parent->id;
        $this->name = $parent->name;
        $this->email = $parent->email;
        $this->editMode = true;
    }

    public function delete($id)
    {
        StudentParent::destroy($id);
        session()->flash('message', 'Parent deleted successfully!');
    }
}
