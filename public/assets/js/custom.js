// custom.js

function toggleSpinners(show) {
    const spinnerContainer = document.getElementById("spinner-container");
    if (spinnerContainer) {
        spinnerContainer.style.display = show ? "flex" : "none";
    }
}

document.addEventListener("DOMContentLoaded", () => {
    //repeater logic starts
    let formGroupCount = 0;
    function initializeRepeater() {
        const classroomRepeater = document.getElementById("repeater");
        const firstClassroomGroup =
            classroomRepeater.querySelector(".form-group");

        classroomRepeater.innerHTML = "";
        firstClassroomGroup.classList.add(`form-${formGroupCount}`);
        classroomRepeater.appendChild(firstClassroomGroup);
        resetInputs(firstClassroomGroup);
        document.getElementById("add-repeater-form").hidden = false;
    }

    function addRepeaterItem() {
        const repeaterContainer = document.getElementById("repeater");
        const firstFormGroup = repeaterContainer.querySelector(".form-group");

        const clonedFormGroup = firstFormGroup.cloneNode(true);
        formGroupCount++;
        clonedFormGroup.classList.forEach((className) => {
            if (className.startsWith("form-")) {
                clonedFormGroup.classList.remove(className);
            }
        });
        clonedFormGroup.classList.add(`form-${formGroupCount}`);

        const wrapperDiv = document.createElement("div");
        wrapperDiv.classList.add("repeater-item");

        resetInputs(clonedFormGroup);

        attachAcademicLevelChangeListener(clonedFormGroup);

        wrapperDiv.appendChild(clonedFormGroup);
        repeaterContainer.appendChild(wrapperDiv);
    }

    function clearRepeaterItems() {
        const repeaterContainer = document.getElementById("repeater");
        const repeaterItems =
            repeaterContainer.querySelectorAll(".repeater-item");
        repeaterItems.forEach((item) => item.remove());
    }

    function resetInputs(formGroup) {
        formGroup.querySelectorAll("input").forEach((input) => {
            input.value = "";
        });
        formGroup.querySelectorAll("select").forEach((select) => {
            select.selectedIndex = 0;
        });
    }

    //repeater logic ends

    //academic selector change starts
    function attachAcademicLevelChangeListener(formGroup) {
        const academicLevelSelect = formGroup.querySelector(
            "#field-2-academic-level"
        );
        if (academicLevelSelect) {
            academicLevelSelect.addEventListener("change", function () {
                const academicLevelId = this.value;
                const classroomsList =
                    formGroup.querySelector("#field-3-classroom");
                classroomsList.innerHTML = "";

                if (academicLevelId) {
                    fetch(
                        `/classrooms/by-academic-level?academic_level_id=${academicLevelId}`
                    )
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.length === 0) {
                                const noOption =
                                    document.createElement("option");
                                noOption.textContent =
                                    "No classrooms available";
                                noOption.disabled = true;
                                classroomsList.appendChild(noOption);
                            } else {
                                data.forEach((classroom) => {
                                    const option =
                                        document.createElement("option");
                                    option.value = classroom.id;
                                    option.textContent = classroom.name;
                                    classroomsList.appendChild(option);
                                });
                            }
                        })
                        .catch((error) => {
                            console.error(
                                "Error retrieving classrooms:",
                                error.message
                            );
                        });
                } else {
                    classroomsList.innerHTML = "";
                }
            });
        }
    }
    //academic selector process the change ends

    // StaticModal for delete initialization for confirmation actions starts
    const staticBackdrop = document.getElementById("staticBackdrop");
    if (staticBackdrop) {
        const staticModalBody = document.getElementById("staticModalBody");

        const confirmActionButton = document.getElementById(
            "confirmActionButton"
        );
        let actionUrl = "";
        let actionType = "";

        staticBackdrop.addEventListener("show.bs.modal", function (event) {
            const button = event.relatedTarget;
            const action = button.getAttribute("data-action");
            const title = button.getAttribute("data-title");
            const body = button.getAttribute("data-body");

            document.getElementById("staticBackdropLabel").textContent =
                title || "Confirm Action";
            staticModalBody.textContent =
                body || "Are you sure you want to proceed?";

            if (action === "delete") {
                actionUrl = button.getAttribute("data-url");
                actionType = "DELETE";
                confirmActionButton.textContent = "Delete";
                confirmActionButton.classList.remove("btn-primary");
                confirmActionButton.classList.add("btn-danger");
            } else {
                confirmActionButton.textContent = "Understood";
                confirmActionButton.classList.remove("btn-danger");
                confirmActionButton.classList.add("btn-primary");
            }
        });

        confirmActionButton.addEventListener("click", function () {
            if (actionType === "DELETE") {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = actionUrl;
                const csrfField = document.createElement("input");
                csrfField.type = "hidden";
                csrfField.name = "_token";
                csrfField.value = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");

                const methodField = document.createElement("input");
                methodField.type = "hidden";
                methodField.name = "_method";
                methodField.value = "DELETE";

                form.appendChild(csrfField);
                form.appendChild(methodField);
                document.body.appendChild(form);

                form.submit();
            }
        });

        //bulk delete for models
        document
            .getElementById("selectAll")
            .addEventListener("change", function (e) {
                let checkboxes = document.querySelectorAll(".selectRow");
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = e.target.checked;
                });
            });
        let actionBulkUrl = "";
        document
            .getElementById("bulkDeleteBtn")
            .addEventListener("click", function () {
                let selectedIds = [];
                document
                    .querySelectorAll(".selectRow:checked")
                    .forEach(function (checkbox) {
                        selectedIds.push(checkbox.value);
                    });

                if (selectedIds.length === 0) {
                    $("#danger-alert-message").text(
                        "Please select at least one item to delete."
                    );
                    $("#danger-alert-modal").modal("show");
                    return;
                }

                const modelType = this.getAttribute("data-model");

                switch (modelType) {
                    case "academic_levels":
                        actionBulkUrl = "/academic_levels/bulkDelete";
                        break;
                    case "classrooms":
                        actionBulkUrl = "/classrooms/bulkDelete";
                        break;
                    case "sections":
                        actionBulkUrl = "/sections/bulkDelete";
                        break;
                    case "students":
                        actionBulkUrl = "/students/bulkDelete";
                        break;
                    case "graduations":
                        actionBulkUrl = "/graduations/bulkDelete";
                        break;
                    case "promotions":
                        actionBulkUrl = "/promotions/list/bulkDelete";
                        break;
                    case "fees":
                        actionBulkUrl = "/fees-students/bulkDelete";
                        break;
                    case "fee_invoices":
                        actionBulkUrl = "/fee-invoices/bulkDelete";
                        break;
                    case "receipt_students":
                        actionBulkUrl = "/receipt-students/bulkDelete";
                        break;
                    case "paymentFee_students":
                        actionBulkUrl = "/paymentFee-students/bulkDelete";
                        break;
                    case "processingFee_students":
                        actionBulkUrl = "/processingFee-students/bulkDelete";
                        break;
                    case "subjects_list":
                        actionBulkUrl = "/subjects-list/bulkDelete";
                        break;
                    case "exams_list":
                        actionBulkUrl = "/exams-list/bulkDelete";
                        break;
                    case "questions_list":
                        actionBulkUrl = "/questions-list/bulkDelete";
                        break;
                    case "libraries_list":
                        actionBulkUrl = "/libraries-list/bulkDelete";
                        break;
                    default:
                        $("#danger-alert-message").text("invalid modal type.");
                        $("#danger-alert-modal").modal("show");
                        return;
                }
                const title = "Confirm Bulk Delete";
                let body;

                if (modelType === "graduations") {
                    body = `Are you sure you want to undo the selected ${modelType.replace(
                        "_",
                        " "
                    )}?`;
                } else {
                    body = `Are you sure you want to delete the selected ${modelType.replace(
                        "_",
                        " "
                    )}?`;
                }
                document.getElementById("staticBackdropLabel").textContent =
                    title;
                staticModalBody.textContent = body;

                const modal = new bootstrap.Modal(staticBackdrop);
                modal.show();
            });

        confirmActionButton.addEventListener("click", function () {
            const selectedIds = [];

            document
                .querySelectorAll(".selectRow:checked")
                .forEach(function (checkbox) {
                    selectedIds.push(checkbox.value);
                });

            if (selectedIds.length > 0) {
                confirmActionButton.innerText = "Processing...";
                fetch(actionBulkUrl, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ ids: selectedIds }),
                });

                location.reload();
            }
        });
    }
    // StaticModal for delete initialization for confirmation actions ends

    // Function to setup the form

    let isAcademicLevelListenerAttached = false;
    const setupForm = (
        form,
        modalTitle,
        action,
        fields,
        buttonText,
        method = "POST",
        hiddenMethod = "PUT",
        showRepeaterButton = false
    ) => {
        modalTitle.textContent = buttonText;

        form.action = action;
        if (!isAcademicLevelListenerAttached) {
            if (typeof sectionForm !== "undefined" && sectionForm) {
                attachAcademicLevelChangeListener(sectionForm);
            } else {
                console.warn("sectionForm is not defined or does not exist.");
            }
            isAcademicLevelListenerAttached = true;
        }
        clearRepeaterItems();
        fields.forEach(({ id, value }) => {
            document.getElementById(id).value = value;
        });

        const existingMethodInput = form.querySelector("input[name='_method']");
        if (existingMethodInput) {
            existingMethodInput.remove();
        }

        if (method !== "POST") {
            const hiddenMethodInput = document.createElement("input");
            hiddenMethodInput.type = "hidden";
            hiddenMethodInput.name = "_method";
            hiddenMethodInput.value = hiddenMethod;
            form.appendChild(hiddenMethodInput);
        }
        const addRepeaterButton = document.getElementById("add-repeater-form");
        if (addRepeaterButton) {
            addRepeaterButton.hidden = !showRepeaterButton;
        }
    };

    //Image viewer starts

    function setImageUrl(button) {
        var imageUrl = button.getAttribute("data-image-url");
        document.getElementById("imageViewer").src = imageUrl;
    }

    //Image viewer ends

    // Academic level form starts
    const academicLevelForm = document.getElementById("academic-level-form");
    if (academicLevelForm) {
        const academicLevelModalTitle = document.getElementById("modal-title");
        const academicLevelEditButtons = document.querySelectorAll(
            ".edit-academic-level"
        );

        academicLevelEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                setupForm(
                    academicLevelForm,
                    academicLevelModalTitle,
                    `/academic_levels/${this.getAttribute("data-id")}`,
                    [
                        {
                            id: "field-1-academic-level",
                            value: this.getAttribute("data-name"),
                        },
                        {
                            id: "field-2-academic-level",
                            value: this.getAttribute("data-description"),
                        },
                    ],
                    "Update Academic Level",
                    "PUT"
                );
            });
        });

        document
            .getElementById("add-academic-level")
            .addEventListener("click", function () {
                setupForm(
                    academicLevelForm,
                    academicLevelModalTitle,
                    `/academic_levels`,
                    [
                        { id: "field-1-academic-level", value: "" },
                        { id: "field-2-academic-level", value: "" },
                    ],
                    "Add Academic Level"
                );
            });

        academicLevelForm.addEventListener("submit", function (event) {
            const saveButton = document.getElementById(
                "save-button-academic-level"
            );
            if (saveButton) {
                toggleSpinners(true);
                saveButton.disabled = true;
                saveButton.textContent = "Saving...";
            }
        });
    }
    // Academic level form ends

    // Classrooms submission edit and add starts
    const classroomForm = document.getElementById("classroom-form");
    if (classroomForm) {
        const classroomModalTitle = document.getElementById("modal-title");
        const classroomEditButtons =
            document.querySelectorAll(".edit-classroom");
        const saveButtonClassroom = document.getElementById(
            "save-button-classroom"
        );

        classroomEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const classroomId = this.getAttribute("data-id");
                setupForm(
                    classroomForm,
                    classroomModalTitle,
                    `/classrooms/${classroomId}`,
                    [
                        {
                            id: "field-1-classroom",
                            value: this.getAttribute("data-name"),
                        },
                    ],
                    "Update Classroom",
                    "PUT",
                    "PUT",
                    false
                );

                const academicLevelSelect =
                    document.getElementById("field-2-classroom");
                const academicLevelText = this.getAttribute(
                    "data-academic-level"
                );
                if (academicLevelSelect) {
                    Array.from(academicLevelSelect.options).forEach(
                        (option) => {
                            if (
                                option.textContent.trim() ===
                                academicLevelText.trim()
                            ) {
                                option.selected = true;
                            }
                        }
                    );
                }
            });
        });

        document
            .getElementById("add-classroom")
            .addEventListener("click", function () {
                initializeRepeater();
                setupForm(
                    classroomForm,
                    classroomModalTitle,
                    `/classrooms`,
                    [
                        { id: "field-1-classroom", value: "" },
                        { id: "field-2-classroom", value: "" },
                    ],
                    "Add Classroom",
                    "POST",
                    undefined,
                    true
                );
            });

        document
            .getElementById("add-repeater-form")
            .addEventListener("click", function (e) {
                e.preventDefault();
                addRepeaterItem();
            });

        classroomForm.addEventListener("submit", function (event) {
            toggleSpinners(true);
            if (saveButtonClassroom) {
                saveButtonClassroom.disabled = true;
                saveButtonClassroom.textContent = "Saving...";
            }
        });
    }
    // end of Classrooms submission edit and add

    // sections submission edit and add starts
    const sectionForm = document.getElementById("section-form");
    if (sectionForm) {
        const sectionModalTitle = document.getElementById("modal-title");
        const sectionEditButtons = document.querySelectorAll(".edit-section");
        const saveButtonSection = document.getElementById(
            "save-button-section"
        );

        sectionEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const sectionId = this.getAttribute("data-id");
                setupForm(
                    sectionForm,
                    sectionModalTitle,
                    `/sections/${sectionId}`,
                    [
                        {
                            id: "field-1-section",
                            value: this.getAttribute("data-name"),
                        },
                    ],
                    "Update Section",
                    "PUT",
                    "PUT",
                    false
                );

                const academicLevelSelect = document.getElementById(
                    "field-2-academic-level"
                );
                const sectionAcademicLevelId = this.getAttribute(
                    "data-academic-level"
                );
                if (academicLevelSelect) {
                    Array.from(academicLevelSelect.options).forEach(
                        (option) => {
                            option.selected =
                                option.textContent.trim() ===
                                sectionAcademicLevelId.trim();
                        }
                    );
                }

                const classroomSelect =
                    document.getElementById("field-3-classroom");
                const sectionClassroomId = this.getAttribute("data-classroom");
                if (classroomSelect) {
                    Array.from(classroomSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() === sectionClassroomId;
                    });
                }

                const statusSelect = document.getElementById("field-4-status");
                const sectionStatus = this.getAttribute("data-status");
                if (statusSelect) {
                    Array.from(statusSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() === sectionStatus;
                    });
                }

                const teachersSelect =
                    document.getElementById("field-5-teachers");
                const sectionTeacherIds = JSON.parse(
                    this.getAttribute("data-teacher-ids")
                );

                if (teachersSelect) {
                    console.log("Section Teacher IDs:", sectionTeacherIds);

                    Array.from(teachersSelect.options).forEach((option) => {
                        const isSelected = sectionTeacherIds.includes(
                            parseInt(option.value)
                        );
                        console.log(
                            `Option value: ${option.value}, Selected: ${isSelected}`
                        );
                        option.selected = isSelected;
                    });
                }
            });
        });

        document
            .getElementById("add-section")
            .addEventListener("click", function () {
                initializeRepeater();

                setupForm(
                    sectionForm,
                    sectionModalTitle,
                    `/sections`,
                    [
                        { id: "field-1-section", value: "" },
                        { id: "field-2-academic-level", value: "" },
                        { id: "field-3-classroom", value: "" },
                        { id: "field-4-status", value: "" },
                        { id: "field-5-teachers", value: [] },
                    ],
                    "Add Section",
                    "POST",
                    undefined,
                    true
                );
                const teachersSelect =
                    document.getElementById("field-5-teachers");
                if (teachersSelect) {
                    Array.from(teachersSelect.options).forEach((option) => {
                        option.selected = false;
                    });
                }
            });

        document
            .getElementById("add-repeater-form")
            .addEventListener("click", function (e) {
                e.preventDefault();
                addRepeaterItem();
            });

        sectionForm.addEventListener("submit", function (event) {
            toggleSpinners(true);
            if (saveButtonSection) {
                saveButtonSection.disabled = true;
                saveButtonSection.textContent = "Saving...";
            }
        });
    }
    // end of sections submission edit and add

    // teachers submission edit and add starts
    const teacherForm = document.getElementById("teacher-form");

    if (teacherForm) {
        const teacherModalTitle = document.getElementById("modal-title");
        const teacherEditButtons = document.querySelectorAll(".edit-teacher");
        const saveButtonTeacher = document.getElementById(
            "save-button-teacher"
        );

        teacherEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const teacherId = this.getAttribute("data-id");
                console.log("Teacher ID:", teacherId);

                const formData = [
                    {
                        id: "field-1-first-name",
                        value: this.getAttribute("data-first-name"),
                    },
                    {
                        id: "field-2-last-name",
                        value: this.getAttribute("data-last-name"),
                    },
                    {
                        id: "field-3-email",
                        value: this.getAttribute("data-email"),
                    },
                    { id: "field-4-password", value: "" },
                    {
                        id: "field-5-address",
                        value: this.getAttribute("data-address"),
                    },
                    {
                        id: "field-6-gender",
                        value: this.getAttribute("data-gender"),
                    },
                    {
                        id: "field-7-specialization",
                        value: this.getAttribute("data-specialization"),
                    },
                    {
                        id: "field-8-join-date",
                        value: this.getAttribute("data-join-date"),
                    },
                ];

                console.log("Form Data:", formData);

                setupForm(
                    teacherForm,
                    teacherModalTitle,
                    `/teachers/${teacherId}`,
                    formData,
                    "Update Teacher",
                    "PUT"
                );

                const genderSelect = document.getElementById("field-6-gender");
                if (genderSelect) {
                    Array.from(genderSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-gender");
                    });
                }

                const specializationSelect = document.getElementById(
                    "field-7-specialization"
                );
                if (specializationSelect) {
                    Array.from(specializationSelect.options).forEach(
                        (option) => {
                            option.selected =
                                option.textContent.trim() ===
                                this.getAttribute("data-specialization");
                        }
                    );
                }
            });
        });

        document
            .getElementById("add-teacher")
            .addEventListener("click", function () {
                initializeRepeater();
                setupForm(
                    teacherForm,
                    teacherModalTitle,
                    `/teachers`,
                    [
                        { id: "field-1-first-name", value: "" },
                        { id: "field-2-last-name", value: "" },
                        { id: "field-3-email", value: "" },
                        { id: "field-4-password", value: "" },
                        { id: "field-5-address", value: "" },
                        { id: "field-6-gender", value: "" },
                        { id: "field-7-specialization", value: "" },
                        { id: "field-8-join-date", value: "" },
                    ],
                    "Add Teacher",
                    "POST",
                    undefined,
                    true
                );
            });

        document
            .getElementById("add-repeater-form")
            .addEventListener("click", function (e) {
                e.preventDefault();
                addRepeaterItem();
            });

        teacherForm.addEventListener("submit", function (event) {
            toggleSpinners(true);
            if (saveButtonTeacher) {
                saveButtonTeacher.disabled = true;
                saveButtonTeacher.textContent = "Saving...";
            }
        });
    }

    // end of Teachers submission edit and add

    // Students submission edit and add starts
    const studentForm = document.getElementById("student-form");

    if (studentForm) {
        const studentModalTitle = document.getElementById(
            "modal-title-student"
        );
        const studentEditButtons = document.querySelectorAll(".edit-student");
        const saveButtonStudent = document.getElementById(
            "save-button-student"
        );

        studentEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                window.scrollTo({ top: 0, behavior: "smooth" });
                const studentId = this.getAttribute("data-id");
                console.log("Student ID:", studentId);

                const formData = [
                    {
                        id: "field-1-student-name",
                        value: this.getAttribute("data-name"),
                    },
                    {
                        id: "field-2-student-email",
                        value: this.getAttribute("data-email"),
                    },
                    {
                        id: "field-3-student-gender",
                        value: this.getAttribute("data-gender"),
                    },
                    {
                        id: "field-4-student-blood",
                        value: this.getAttribute("data-blood"),
                    },
                    {
                        id: "field-5-student-nationality",
                        value: this.getAttribute("data-nationality"),
                    },
                    {
                        id: "field-6-student-dob",
                        value: this.getAttribute("data-dob"),
                    },
                    {
                        id: "field-7-student-academic-level",
                        value: this.getAttribute("data-academic-level"),
                    },
                    {
                        id: "field-8-student-classroom",
                        value: this.getAttribute("data-classroom"),
                    },
                    {
                        id: "field-9-student-section",
                        value: this.getAttribute("data-section"),
                    },
                    {
                        id: "field-10-student-parent",
                        value: this.getAttribute("data-parent"),
                    },
                    {
                        id: "field-11-student-academic-year",
                        value: this.getAttribute("data-academic-year"),
                    },
                ];

                setupForm(
                    studentForm,
                    studentModalTitle,
                    `/students/${studentId}`,
                    formData,
                    "Update Student",
                    "PUT"
                );

                const genderSelect = document.getElementById(
                    "field-3-student-gender"
                );
                if (genderSelect) {
                    Array.from(genderSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-gender");
                    });
                }

                const academicLevelSelect = document.getElementById(
                    "field-7-student-academic-level"
                );
                if (academicLevelSelect) {
                    Array.from(academicLevelSelect.options).forEach(
                        (option) => {
                            option.selected =
                                option.textContent.trim() ===
                                this.getAttribute("data-academic-level");
                        }
                    );
                }

                const classroomSelect = document.getElementById(
                    "field-8-student-classroom"
                );
                if (classroomSelect) {
                    Array.from(classroomSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-classroom");
                    });
                }

                const sectionSelect = document.getElementById(
                    "field-9-student-section"
                );
                if (sectionSelect) {
                    Array.from(sectionSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-section");
                    });
                }
            });
        });

        document
            .getElementById("add-student")
            .addEventListener("click", function () {
                initializeRepeater();
                setupForm(
                    studentForm,
                    studentModalTitle,
                    `/students`,
                    [
                        { id: "field-1-student-name", value: "" },
                        { id: "field-2-student-email", value: "" },
                        { id: "field-3-student-gender", value: "" },
                        { id: "field-4-student-blood", value: "" },
                        { id: "field-5-student-nationality", value: "" },
                        { id: "field-6-student-dob", value: "" },
                        { id: "field-7-student-academic-level", value: "" },
                        { id: "field-8-student-classroom", value: "" },
                        { id: "field-9-student-section", value: "" },
                        { id: "field-10-student-parent", value: "" },
                        { id: "field-11-student-academic-year", value: "" },
                    ],
                    "Add Student",
                    "POST",
                    undefined,
                    true
                );
            });
        document
            .getElementById("add-repeater-form")
            .addEventListener("click", function (e) {
                e.preventDefault();
                addRepeaterItem();
            });
        studentForm.addEventListener("submit", function (event) {
            toggleSpinners(true);
            if (saveButtonStudent) {
                saveButtonStudent.disabled = true;
                saveButtonStudent.textContent = "Saving...";
            }
        });
    }

    // End of Students submission edit and add

    //graduations submit starts
    const editGraduation = document.querySelectorAll(".edit-graduation");
    if (editGraduation) {
        editGraduation.forEach((button) => {
            button.addEventListener("click", function () {
                const studentId = this.getAttribute("data-id");
                const studentName = this.getAttribute("data-name");
                document.getElementById("modal-title").textContent =
                    "Graduation Undo";
                document.getElementById("modal-message").textContent =
                    "Are you sure to undo the graduation for the student: " +
                    studentName;

                const form = document.getElementById("warn-form");
                form.action = "graduations/" + studentId;
                form.dataset.studentId = studentId;

                $("#warning-alert-modal").modal("show");
            });
        });
    }

    //graduations submit ends

    //fees form starts
    const feeForm = document.getElementById("fee-form");

    if (feeForm) {
        const feeModalTitle = document.getElementById("modal-title");
        const feeEditButtons = document.querySelectorAll(".edit-fee");
        const saveButtonFee = document.getElementById("save-button-fee");

        // Function to set selected option in a dropdown
        const setSelectedOption = (selectElement, value) => {
            if (selectElement) {
                Array.from(selectElement.options).forEach((option) => {
                    option.selected = option.textContent.trim() === value;
                });
            }
        };

        // Setup event listeners for edit buttons
        feeEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                window.scrollTo({ top: 0, behavior: "smooth" });
                const feeId = this.getAttribute("data-id");

                const formData = [
                    {
                        id: "field-1-title",
                        value: this.getAttribute("data-title"),
                    },
                    {
                        id: "field-3-amount",
                        value: this.getAttribute("data-amount"),
                    },
                    {
                        id: "field-7-student-academic-level",
                        value: this.getAttribute("data-academic-level"),
                    },
                    {
                        id: "field-8-student-classroom",
                        value: this.getAttribute("data-classroom"),
                    },
                    {
                        id: "field-9-student-section",
                        value: this.getAttribute("data-section"),
                    },
                    {
                        id: "field-7-description",
                        value: this.getAttribute("data-description"),
                    },
                    {
                        id: "field-8-year",
                        value: this.getAttribute("data-year"),
                    },
                ];

                // Call setupForm with data
                setupForm(
                    feeForm,
                    feeModalTitle,
                    `/fees/${feeId}`,
                    formData,
                    "Update Fee",
                    "PUT"
                );

                // Set dropdown selections
                setSelectedOption(
                    document.getElementById("field-7-student-academic-level"),
                    this.getAttribute("data-academic-level")
                );
                setSelectedOption(
                    document.getElementById("field-8-student-classroom"),
                    this.getAttribute("data-classroom")
                );
                setSelectedOption(
                    document.getElementById("field-9-student-section"),
                    this.getAttribute("data-section")
                );
            });
        });

        // Event listener for the add fee button
        document
            .getElementById("add-fee")
            .addEventListener("click", function () {
                initializeRepeater();
                setupForm(
                    feeForm,
                    feeModalTitle,
                    `/fees`,
                    [
                        { id: "field-1-title", value: "" },
                        { id: "field-3-amount", value: "" },
                        { id: "field-7-student-academic-level", value: "" },
                        { id: "field-8-student-classroom", value: "" },
                        { id: "field-9-student-section", value: "" },
                        { id: "field-7-description", value: "" },
                        { id: "field-8-year", value: "" },
                    ],
                    "Add Fee",
                    "POST"
                );
            });

        // Additional form actions
        feeForm.addEventListener("submit", function (event) {
            toggleSpinners(true);
            if (saveButtonFee) {
                saveButtonFee.disabled = true;
                saveButtonFee.textContent = "Saving...";
            }
        });
    }

    //fees form ends

    //invoiceTypeForm form starts
    const invoiceTypeForm = document.getElementById("invoice-type-form");

    if (invoiceTypeForm) {
        const invoiceTypeModalTitle = document.getElementById("modal-title");
        const invoiceTypeEditButtons =
            document.querySelectorAll(".edit-invoice-type");
        const invoiceTypeAddButtons =
            document.getElementById("add-invoice-type");
        const saveButtonInvoiceType = document.getElementById(
            "save-button-invoice-type"
        );

        invoiceTypeEditButtons.forEach((button, index) => {
            button.addEventListener("click", function () {
                const voiceTypeId = this.getAttribute("data-id");

                const formData = [
                    {
                        id: "field-1-title",
                        value: this.getAttribute("data-title"),
                    },
                    {
                        id: "field-2-amount",
                        value: this.getAttribute("data-amount"),
                    },
                    {
                        id: "field-1-student-id",
                        value: this.getAttribute("data-student"),
                    },
                    {
                        id: "field-7-student-academic-level",
                        value: this.getAttribute("data-academic-level"),
                    },
                    {
                        id: "field-8-student-classroom",
                        value: this.getAttribute("data-classroom"),
                    },
                    {
                        id: "field-9-student-section",
                        value: this.getAttribute("data-section"),
                    },
                    {
                        id: "field-6-fee",
                        value: this.getAttribute("data-fee"),
                    },
                    {
                        id: "field-7-year",
                        value: this.getAttribute("data-year"),
                    },
                    {
                        id: "field-8-fee-type",
                        value: this.getAttribute("data-fee-type"),
                    },
                    {
                        id: "field-9-description",
                        value: this.getAttribute("data-description"),
                    },
                ];

                setupForm(
                    invoiceTypeForm,
                    invoiceTypeModalTitle,
                    `/fee_invoices/${voiceTypeId}`,
                    formData,
                    "Update Voice Type",
                    "PUT"
                );

                const academicLevelSelect = document.getElementById(
                    "field-7-student-academic-level"
                );
                if (academicLevelSelect) {
                    Array.from(academicLevelSelect.options).forEach(
                        (option) => {
                            option.selected =
                                option.textContent.trim() ===
                                this.getAttribute("data-academic-level");
                        }
                    );
                }

                const classroomSelect = document.getElementById(
                    "field-8-student-classroom"
                );
                if (classroomSelect) {
                    Array.from(classroomSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-classroom");
                    });
                }

                const sectionSelect = document.getElementById(
                    "field-9-student-section"
                );
                if (sectionSelect) {
                    Array.from(sectionSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-section");
                    });
                }

                const studentSelect =
                    document.getElementById("field-1-student-id");
                if (studentSelect) {
                    Array.from(studentSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-student");
                    });
                }

                const feeTypeSelect =
                    document.getElementById("field-8-fee-type");
                if (feeTypeSelect) {
                    Array.from(feeTypeSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-fee-type");
                    });
                }
            });
        });

        invoiceTypeAddButtons.addEventListener("click", function () {
            initializeRepeater();
            setupForm(
                invoiceTypeForm,
                invoiceTypeModalTitle,
                `/fee_invoices`,
                [
                    { id: "field-1-title", value: "" },
                    { id: "field-2-amount", value: "" },
                    { id: "field-1-student-id", value: "" },
                    { id: "field-7-student-academic-level", value: "" },
                    { id: "field-8-student-classroom", value: "" },
                    { id: "field-9-student-section", value: "" },
                    { id: "field-6-fee", value: "" },
                    { id: "field-7-year", value: "" },
                    { id: "field-8-fee-type", value: "" },
                    { id: "field-9-description", value: "" },
                ],
                "Add Voice Type",
                "POST",
                undefined,
                true
            );
        });
        document
            .getElementById("add-repeater-form")
            .addEventListener("click", function (e) {
                e.preventDefault();
                addRepeaterItem();
            });

        invoiceTypeForm.addEventListener("submit", function (event) {
            toggleSpinners(true);
            if (saveButtonInvoiceType) {
                saveButtonInvoiceType.disabled = true;
                saveButtonInvoiceType.textContent = "Saving...";
            }
        });
    }

    //invoiceTypeForm form ends

    //receiptStudentForm form starts
    const receiptStudentForm = document.getElementById("receipt-student-form");

    if (receiptStudentForm) {
        const receiptStudentModalTitle = document.getElementById("modal-title");
        const receiptStudentEditButtons = document.querySelectorAll(
            ".edit-receipt-student"
        );
        const receiptStudentAddButton = document.getElementById(
            "add-receipt-student"
        );
        const saveButtonReceiptStudent = document.getElementById(
            "save-button-receipt-student"
        );

        receiptStudentEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const receiptStudentId = this.getAttribute("data-id");

                const formData = [
                    {
                        id: "field-1-credit",
                        value: this.getAttribute("data-credit"),
                    },
                    {
                        id: "field-2-student",
                        value: this.getAttribute("data-student"),
                    },
                    {
                        id: "field-3-description",
                        value: this.getAttribute("data-description"),
                    },
                ];

                setupForm(
                    receiptStudentForm,
                    receiptStudentModalTitle,
                    `/receiptStudents/${receiptStudentId}`,
                    formData,
                    "Update Receipt Student",
                    "PUT",
                    false
                );

                const studentSelect =
                    document.getElementById("field-2-student");
                if (studentSelect) {
                    Array.from(studentSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-student");
                    });
                }
            });
        });

        receiptStudentAddButton.addEventListener("click", function () {
            setupForm(
                receiptStudentForm,
                receiptStudentModalTitle,
                `/receiptStudents`,
                [
                    { id: "field-1-credit", value: "" },
                    { id: "field-2-student", value: "" },
                    { id: "field-3-description", value: "" },
                ],
                "Add Receipt Student",
                "POST",
                "undefined",
                true
            );
        });
        document
            .getElementById("add-repeater-form")
            .addEventListener("click", function (e) {
                e.preventDefault();
                addRepeaterItem();
            });

        receiptStudentForm.addEventListener("submit", function () {
            toggleSpinners(true);
            if (saveButtonReceiptStudent) {
                saveButtonReceiptStudent.disabled = true;
                saveButtonReceiptStudent.textContent = "Saving...";
            }
        });
    }

    //receiptStudentForm form ends

    // paymentFeesForm form starts
    const paymentFeesForm = document.getElementById("payment-fees-form");

    if (paymentFeesForm) {
        const paymentFeesModalTitle = document.getElementById("modal-title");
        const paymentFeesEditButtons =
            document.querySelectorAll(".edit-payment-fee");
        const paymentFeesAddButton = document.getElementById("add-Payment-fee");
        const saveButtonPaymentFee = document.getElementById(
            "save-button-payment-fee"
        );

        paymentFeesEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const paymentFeeId = this.getAttribute("data-id");

                const formData = [
                    {
                        id: "field-1-credit",
                        value: this.getAttribute("data-credit"),
                    },
                    {
                        id: "field-2-student",
                        value: this.getAttribute("data-student"),
                    },
                    {
                        id: "field-3-description",
                        value: this.getAttribute("data-description"),
                    },
                ];

                setupForm(
                    paymentFeesForm,
                    paymentFeesModalTitle,
                    `/paymentFeeStudents/${paymentFeeId}`,
                    formData,
                    "Update Payment Fee",
                    "PUT"
                );

                const studentSelect =
                    document.getElementById("field-2-student");
                if (studentSelect) {
                    Array.from(studentSelect.options).forEach((option) => {
                        console.log("Option text:", option.textContent.trim());
                        console.log(
                            "Data-student:",
                            this.getAttribute("data-student")
                        );

                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-student");

                        if (option.selected) {
                            console.log(
                                "Selected option:",
                                option.textContent.trim()
                            );
                        }
                    });
                }

                const descriptionSelect = document.getElementById(
                    "field-3-description"
                );
                if (descriptionSelect) {
                    Array.from(descriptionSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-description");
                    });
                }
                const creditSelect = document.getElementById("field-1-credit");
                if (creditSelect) {
                    Array.from(creditSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-credit");
                    });
                }
            });
        });

        paymentFeesAddButton.addEventListener("click", function () {
            initializeRepeater();
            setupForm(
                paymentFeesForm,
                paymentFeesModalTitle,
                `/paymentFeeStudents`,
                [
                    { id: "field-1-credit", value: "" },
                    { id: "field-2-student", value: "" },
                    { id: "field-3-description", value: "" },
                ],
                "Add Payment Fee",
                "POST",
                undefined,
                true
            );
        });

        document
            .getElementById("add-repeater-form")
            .addEventListener("click", function (e) {
                e.preventDefault();
                addRepeaterItem();
            });
        paymentFeesForm.addEventListener("submit", function () {
            toggleSpinners(true);
            if (saveButtonPaymentFee) {
                saveButtonPaymentFee.disabled = true;
                saveButtonPaymentFee.textContent = "Saving...";
            }
        });
    }
    // paymentFeesForm form ends

    // processFeesForm form starts
    const processFeesForm = document.getElementById("processing-fees-form");

    if (processFeesForm) {
        const processFeesModalTitle = document.getElementById("modal-title");
        const processFeesEditButtons = document.querySelectorAll(
            ".edit-processing-fee"
        );
        const processFeesAddButton =
            document.getElementById("add-Processing-fee");
        const saveButtonProcessFee = document.getElementById(
            "save-button-process-fee"
        );

        processFeesEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const processFeeId = this.getAttribute("data-id");

                const formData = [
                    {
                        id: "field-1-credit",
                        value: this.getAttribute("data-credit"),
                    },
                    {
                        id: "field-2-student",
                        value: this.getAttribute("data-student"),
                    },
                    {
                        id: "field-3-description",
                        value: this.getAttribute("data-description"),
                    },
                ];

                setupForm(
                    processFeesForm,
                    processFeesModalTitle,
                    `/processingFeeStudents/${processFeeId}`,
                    formData,
                    "Update Process Fee",
                    "PUT"
                );

                const studentSelect =
                    document.getElementById("field-2-student");
                if (studentSelect) {
                    Array.from(studentSelect.options).forEach((option) => {
                        console.log("Option text:", option.textContent.trim());
                        console.log(
                            "Data-student:",
                            this.getAttribute("data-student")
                        );

                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-student");

                        if (option.selected) {
                            console.log(
                                "Selected option:",
                                option.textContent.trim()
                            );
                        }
                    });
                }

                const descriptionSelect = document.getElementById(
                    "field-3-description"
                );
                if (descriptionSelect) {
                    Array.from(descriptionSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-description");
                    });
                }
                const creditSelect = document.getElementById("field-1-credit");
                if (creditSelect) {
                    Array.from(creditSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-credit");
                    });
                }
            });
        });

        processFeesAddButton.addEventListener("click", function () {
            initializeRepeater();
            setupForm(
                processFeesForm,
                processFeesModalTitle,
                `/processFeeStudents`,
                [
                    { id: "field-1-credit", value: "" },
                    { id: "field-2-student", value: "" },
                    { id: "field-3-description", value: "" },
                ],
                "Add Process Fee",
                "POST",
                undefined,
                true
            );
        });

        document
            .getElementById("add-repeater-form")
            .addEventListener("click", function (e) {
                e.preventDefault();
                addRepeaterItem();
            });
        processFeesForm.addEventListener("submit", function () {
            toggleSpinners(true);
            if (saveButtonProcessFee) {
                saveButtonProcessFee.disabled = true;
                saveButtonProcessFee.textContent = "Saving...";
            }
        });
    }

    // processFeesForm form ends

    //subject form starts
    const subjectForm = document.getElementById("subject-form");

    if (subjectForm) {
        const subjectModalTitle = document.getElementById("modal-title");
        const subjectEditButtons = document.querySelectorAll(".edit-subject");
        const subjectAddButton = document.getElementById("add-subject");
        const saveButtonSubject = document.getElementById(
            "save-button-subject"
        );

        subjectEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const subjectId = this.getAttribute("data-id");

                const formData = [
                    {
                        id: "field-1-subject",
                        value: this.getAttribute("data-name"),
                    },
                    {
                        id: "field-2-teacher",
                        value: this.getAttribute("data-section"),
                    },
                    {
                        id: "field-7-student-academic-level",
                        value: this.getAttribute("data-academic-level"),
                    },
                    {
                        id: "field-8-student-classroom",
                        value: this.getAttribute("data-classroom"),
                    },
                ];

                setupForm(
                    subjectForm,
                    subjectModalTitle,
                    `/subjects/${subjectId}`,
                    formData,
                    "Update Subject",
                    "PUT"
                );

                const academicLevelSelect = document.getElementById(
                    "field-7-student-academic-level"
                );
                if (academicLevelSelect) {
                    Array.from(academicLevelSelect.options).forEach(
                        (option) => {
                            option.selected =
                                option.textContent.trim() ===
                                this.getAttribute("data-academic-level");
                        }
                    );
                }

                const classroomSelect = document.getElementById(
                    "field-8-student-classroom"
                );
                if (classroomSelect) {
                    Array.from(classroomSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-classroom");
                    });
                }

                const teacherSelection =
                    document.getElementById("field-2-teacher");
                if (teacherSelection) {
                    Array.from(teacherSelection.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-section");
                    });
                }
            });
        });

        subjectAddButton.addEventListener("click", function () {
            initializeRepeater();
            setupForm(
                subjectForm,
                subjectModalTitle,
                `/subjects`,
                [
                    { id: "field-1-subject", value: "" },
                    { id: "field-2-teacher", value: "" },
                    { id: "field-7-student-academic-level", value: "" },
                    { id: "field-8-student-classroom", value: "" },
                ],
                "Add Subject",
                "POST",
                undefined,
                true
            );
        });

        document
            .getElementById("add-repeater-form")
            .addEventListener("click", function (e) {
                e.preventDefault();
                addRepeaterItem();
            });

        subjectForm.addEventListener("submit", function () {
            toggleSpinners(true);
            if (saveButtonSubject) {
                saveButtonSubject.disabled = true;
                saveButtonSubject.textContent = "Saving...";
            }
        });
    }
    //subject form starts

    // Exam form starts
    const examForm = document.getElementById("exam-form");
    const examTeacherForm = document.getElementById("exam-teacher-form");
    if (examForm || examTeacherForm) {
        const examModalTitle = document.getElementById("modal-title");
        const examEditButtons = document.querySelectorAll(".edit-exam");
        const examAddButton = document.getElementById("add-exam");
        const saveButtonExam = document.getElementById("save-button-exam");

        examEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const examId = this.getAttribute("data-id");

                const formData = [
                    {
                        id: "field-1-exam-name",
                        value: this.getAttribute("data-name"),
                    },
                    {
                        id: "field-7-student-academic-level",
                        value: this.getAttribute("data-academic-level"),
                    },
                    {
                        id: "field-8-student-classroom",
                        value: this.getAttribute("data-classroom"),
                    },
                    {
                        id: "field-4-subject",
                        value: this.getAttribute("data-subject"),
                    },
                ];
                if (examTeacherForm) {
                    const URL = `/teacher/exams/store`;
                    setupForm(
                        examTeacherForm,
                        examModalTitle,
                        URL,
                        formData,
                        "Update Exam",
                        "POST"
                    );
                } else {
                    const URL = `/teacherExams/${examId}`;
                    setupForm(
                        examForm,
                        examModalTitle,
                        URL,
                        formData,
                        "Update Exam",
                        "PUT"
                    );
                }

                const academicLevelSelect = document.getElementById(
                    "field-7-student-academic-level"
                );
                if (academicLevelSelect) {
                    Array.from(academicLevelSelect.options).forEach(
                        (option) => {
                            option.selected =
                                option.textContent.trim() ===
                                this.getAttribute("data-academic-level");
                        }
                    );
                }

                const classroomSelect = document.getElementById(
                    "field-8-student-classroom"
                );
                if (classroomSelect) {
                    Array.from(classroomSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-classroom");
                    });
                }
                const sectionSelect = document.getElementById(
                    "field-9-student-section"
                );
                if (sectionSelect) {
                    Array.from(sectionSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-section");
                    });
                }

                const subjectSelect =
                    document.getElementById("field-4-subject");
                if (subjectSelect) {
                    Array.from(subjectSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-subject");
                    });
                }
            });
        });

        examAddButton.addEventListener("click", function () {
            initializeRepeater();
            setupForm(
                examForm,
                examModalTitle,
                `/exams`,
                [
                    { id: "field-1-exam-name", value: "" },
                    { id: "field-7-student-academic-level", value: "" },
                    { id: "field-8-student-classroom", value: "" },
                    { id: "field-4-subject", value: "" },
                ],
                "Add Exam",
                "POST",
                undefined,
                true
            );
        });

        document
            .getElementById("add-repeater-form")
            .addEventListener("click", function (e) {
                e.preventDefault();
                addRepeaterItem();
            });

        examForm.addEventListener("submit", function () {
            toggleSpinners(true);
            if (saveButtonExam) {
                saveButtonExam.disabled = true;
                saveButtonExam.textContent = "Saving...";
            }
        });
    }
    // Exam form ends

    // Question form starts
    const questionForm = document.getElementById("question-form");

    if (questionForm) {
        const questionModalTitle = document.getElementById("modal-title");
        const questionEditButtons = document.querySelectorAll(".edit-question");
        const questionAddButton = document.getElementById("add-question");
        const saveButtonQuestion = document.getElementById(
            "save-button-question"
        );

        questionEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const questionId = this.getAttribute("data-id");

                const formData = [
                    {
                        id: "field-1-question-text",
                        value: this.getAttribute("data-question-text"),
                    },
                    {
                        id: "field-2-answers",
                        value: this.getAttribute("data-answers"),
                    },
                    {
                        id: "field-3-correct-answer",
                        value: this.getAttribute("data-correct-answer"),
                    },
                    {
                        id: "field-4-score",
                        value: this.getAttribute("data-score"),
                    },
                    {
                        id: "field-5-exam-id",
                        value: this.getAttribute("data-exam-id"),
                    },
                ];

                setupForm(
                    questionForm,
                    questionModalTitle,
                    `/questions/${questionId}`,
                    formData,
                    "Update Question",
                    "PUT"
                );
                const examSelect = document.getElementById("field-5-exam-id");
                const examName = this.getAttribute("data-exam-name");
                if (examSelect && examName) {
                    Array.from(examSelect.options).forEach((option) => {
                        option.selected = option.text.trim() === examName;
                    });
                }

                const answersTextarea =
                    document.getElementById("field-2-answers");

                if (answersTextarea) {
                    const answers = JSON.parse(
                        this.getAttribute("data-answers")
                    );
                    answersTextarea.value = answers.join("\n");
                }

                const correctAnswerInput = document.getElementById(
                    "field-3-correct-answer"
                );
                if (correctAnswerInput) {
                    correctAnswerInput.value = this.getAttribute(
                        "data-correct-answer"
                    );
                }

                const scoreInput = document.getElementById("field-4-score");
                if (scoreInput) {
                    scoreInput.value = this.getAttribute("data-score");
                }
            });
        });

        questionAddButton.addEventListener("click", function () {
            initializeRepeater();
            setupForm(
                questionForm,
                questionModalTitle,
                `/questions`,
                [
                    { id: "field-1-question-text", value: "" },
                    { id: "field-2-answers", value: "" },
                    { id: "field-3-right-answer", value: "" },
                    { id: "field-4-score", value: "" },
                    { id: "field-5-exam-id", value: "" },
                ],
                "Add Question",
                "POST",
                undefined,
                true
            );
        });

        document
            .getElementById("add-repeater-form")
            .addEventListener("click", function (e) {
                e.preventDefault();
                addRepeaterItem();
            });

        questionForm.addEventListener("submit", function () {
            toggleSpinners(true);
            if (saveButtonQuestion) {
                saveButtonQuestion.disabled = true;
                saveButtonQuestion.textContent = "Saving...";
            }
        });
    }

    // Question form ends

    //form starts of the library

    const libraryForm = document.getElementById("book-form");

    if (libraryForm) {
        const libraryModalTitle = document.getElementById("modal-title");
        const libraryEditButtons = document.querySelectorAll(".edit-book");
        const libraryAddButton = document.getElementById("add-book");
        const saveButtonBook = document.getElementById("save-button-book");

        libraryEditButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const bookId = this.getAttribute("data-id");

                const formData = [
                    {
                        id: "field-1-title",
                        value: this.getAttribute("data-title"),
                    },
                    {
                        id: "field-7-student-academic-level",
                        value: this.getAttribute("data-academiclevel"),
                    },
                    {
                        id: "field-8-student-classroom",
                        value: this.getAttribute("data-classroom"),
                    },
                    {
                        id: "field-9-student-section",
                        value: this.getAttribute("data-section"),
                    },
                    {
                        id: "field-2-teacher",
                        value: this.getAttribute("data-teacher"),
                    },
                    {
                        id: "field-5-file",
                        value: this.getAttribute("data-file"),
                    },
                ];

                setupForm(
                    libraryForm,
                    libraryModalTitle,
                    `/libraries/${bookId}`,
                    formData,
                    "Update Book",
                    "PUT"
                );

                const academicLevelSelect = document.getElementById(
                    "field-7-student-academic-level"
                );
                if (academicLevelSelect) {
                    Array.from(academicLevelSelect.options).forEach(
                        (option) => {
                            option.selected =
                                option.innerText.trim() ===
                                this.getAttribute("data-academiclevel");
                        }
                    );
                }

                const classroomSelect = document.getElementById(
                    "field-8-student-classroom"
                );
                if (classroomSelect) {
                    Array.from(classroomSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-classroom");
                    });
                }

                const sectionSelect = document.getElementById(
                    "field-9-student-section"
                );
                if (sectionSelect) {
                    Array.from(sectionSelect.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-section");
                    });
                }

                const teacherSelection =
                    document.getElementById("field-2-teacher");
                if (teacherSelection) {
                    Array.from(teacherSelection.options).forEach((option) => {
                        option.selected =
                            option.textContent.trim() ===
                            this.getAttribute("data-teacher");
                    });
                }
            });
        });

        libraryAddButton.addEventListener("click", function () {
            initializeRepeater();
            setupForm(
                libraryForm,
                libraryModalTitle,
                `/libraries`,
                [
                    { id: "field-1-title", value: "" },
                    { id: "field-7-student-academic-level", value: "" },
                    { id: "field-8-student-classroom", value: "" },
                    { id: "field-9-student-section", value: "" },
                    { id: "field-2-teacher", value: "" },
                    { id: "field-5-file", value: "" },
                ],
                "Add Book",
                "POST",
                undefined,
                true
            );
        });

        document
            .getElementById("add-repeater-form")
            .addEventListener("click", function (e) {
                e.preventDefault();
                addRepeaterItem();
            });

        libraryForm.addEventListener("submit", function () {
            toggleSpinners(true);
            if (saveButtonBook) {
                saveButtonBook.disabled = true;
                saveButtonBook.textContent = "Saving...";
            }
        });
    }

    //form ends of the library

    //fetch the student balance starts
    function fetchAndDisplayBalance(studentId, balanceLabelElement) {
        fetch(`/students/${studentId}/balance`)
            .then((response) => response.json())
            .then((data) => {
                console.log(data.balance);
                balanceLabelElement.value = `Current Balance: ${data.balance}`;
            })
            .catch((error) => {
                console.error("Error fetching student balance:", error);
                balanceLabelElement.innerText = "Current Balance: Unavailable";
            });
    }
    //fetch the student balance ends

    //addReceipt form for one student starts
    const addReceiptButtons = document.querySelectorAll("#add-receipt-student");
    if (addReceiptButtons) {
        addReceiptButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                const studentId = button.getAttribute("data-student-id");
                const studentName = button.getAttribute("data-student-name");
                const studentField = document.querySelector(
                    "#field-2-student-receiptFee"
                );
                studentField.value = studentId;
                const balanceLabelElement = document.querySelector(
                    "#balance-label-receiptFee"
                );
                if (balanceLabelElement) {
                    fetchAndDisplayBalance(studentId, balanceLabelElement);
                }
                balanceLabelElement.textContent = "ds";
                const modalTitleLabel = document.querySelector(
                    "#Receipt-student-modal-label"
                );
                modalTitleLabel.innerText = "Add Receipt for " + studentName;
            });
        });
    }
    //addReceipt form for one student ends

    //add process fee form for one student starts
    const addProcessFeeButtons = document.querySelectorAll(
        "#add-processFee-student"
    );

    if (addProcessFeeButtons) {
        addProcessFeeButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                const studentId = button.getAttribute("data-student-id");
                const studentName = button.getAttribute("data-student-name");
                const studentField = document.querySelector(
                    "#field-2-student-processFee"
                );
                if (studentField) {
                    studentField.value = studentId;
                }
                const balanceLabelElement = document.querySelector(
                    "#balance-label-processFee"
                );
                if (balanceLabelElement) {
                    fetchAndDisplayBalance(studentId, balanceLabelElement);
                }

                const modalTitleLabel = document.querySelector(
                    "#processFee-student-modal-label"
                );
                if (modalTitleLabel) {
                    modalTitleLabel.innerText =
                        "Add Process Fee for " + studentName;
                }
            });
        });
    }
    //add process fee form for one student ends

    //addPayment form for one student starts
    const addPaymentFeeButtons = document.querySelectorAll(
        "#add-paymentFee-student"
    );

    if (addPaymentFeeButtons) {
        addPaymentFeeButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                const studentId = button.getAttribute("data-student-id");
                const studentName = button.getAttribute("data-student-name");
                const studentField = document.querySelector(
                    "#field-2-student-paymentFee"
                );
                studentField.value = studentId;
                const balanceLabelElement = document.querySelector(
                    "#balance-label-paymentFee"
                );
                if (balanceLabelElement) {
                    fetchAndDisplayBalance(studentId, balanceLabelElement);
                }
                const modalTitleLabel = document.querySelector(
                    "#paymentFee-student-modal-label"
                );
                modalTitleLabel.innerText =
                    "Add Payment Fee for " + studentName;
            });
        });
    }
    //addPayment form for one student ends
});

//activate links
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".nav-link");

    links.forEach((link) => {
        const linkHref = link.getAttribute("href");

        if (window.location.href.includes(linkHref)) {
            link.parentElement.classList.add("active");
        } else {
            link.parentElement.classList.remove("active");
        }

        link.addEventListener("click", function (event) {
            event.preventDefault();
            window.location.href = linkHref;
        });
    });
});

// livewire script
