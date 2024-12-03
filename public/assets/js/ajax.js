$(document).ready(function () {
    // Helper function to retrieve the scoped field inside a repeater item if present
    function getScopedField(selector, context) {
        const repeaterItem = context.closest(".repeater-item");
        return repeaterItem.length ? repeaterItem.find(selector) : $(selector);
    }

    // Generic function to update dropdown options
    function updateDropdown(dropdownField, options, defaultMessage) {
        dropdownField.empty();
        if (options.length > 0) {
            options.forEach((option) => {
                dropdownField.append(
                    $("<option>", { value: option.id, text: option.name })
                );
            });
            dropdownField.trigger("change");
        } else {
            dropdownField.append(
                $("<option>", { value: "", text: defaultMessage })
            );
        }
    }

    // Event handler for academic level change
    $(document).on("change", "#field-7-student-academic-level", function () {
        const academicLevelId = $(this).val();
        const currentField = $(this);

        if (academicLevelId) {
            $.ajax({
                url: "/classrooms/by-academic-level",
                type: "GET",
                data: { academic_level_id: academicLevelId },
                success: function (data) {
                    const classroomField = getScopedField(
                        "#field-8-student-classroom",
                        currentField
                    );
                    updateDropdown(
                        classroomField,
                        data,
                        "No classrooms available"
                    );

                    if (!data.length) {
                        updateDropdown(
                            getScopedField(
                                "#field-9-student-section",
                                currentField
                            ),
                            [],
                            "Select a classroom first"
                        );
                        updateDropdown(
                            getScopedField("#field-1-student-id", currentField),
                            [],
                            "Select a section that contains students first"
                        );
                        getScopedField(
                            "#field-8-old-academic-year",
                            currentField
                        ).val("no data available");
                    }
                },
                error: function () {
                    alertModal("Failed to retrieve classrooms.");
                },
            });
        } else {
            getScopedField("#field-8-student-classroom", currentField).empty();
            getScopedField("#field-9-student-section", currentField).empty();
            getScopedField("#field-1-student-id", currentField).empty();
        }
    });

    // Event handler for classroom change
    $(document).on("change", "#field-8-student-classroom", function () {
        const classroomId = $(this).val();
        const currentField = $(this);

        if (classroomId) {
            $.ajax({
                url: "/sections",
                type: "GET",
                data: { id: classroomId },
                success: function (data) {
                    const sectionField = getScopedField(
                        "#field-9-student-section",
                        currentField
                    );
                    updateDropdown(
                        sectionField,
                        data.sections,
                        "No sections available"
                    );

                    if (!data.sections.length) {
                        updateDropdown(
                            getScopedField("#field-1-student-id", currentField),
                            [],
                            "Select a section first"
                        );
                    }
                },
                error: function () {
                    alertModal("Failed to retrieve sections.");
                },
            });
        } else {
            getScopedField("#field-9-student-section", currentField).empty();
            getScopedField("#field-1-student-id", currentField).empty();
        }
    });

    // Event handler for section change
    $(document).on("change", "#field-9-student-section", function () {
        const sectionId = $(this).val();
        const currentField = $(this);

        if (sectionId) {
            $.ajax({
                url: "/students-available/by-section",
                type: "GET",
                data: { section_id: sectionId },
                success: function (data) {
                    const studentField = getScopedField(
                        "#field-1-student-id",
                        currentField
                    );
                    updateDropdown(
                        studentField,
                        data.students,
                        "No students available"
                    );
                },
                error: function () {
                    alertModal("Failed to retrieve students.");
                    updateDropdown(
                        getScopedField("#field-1-student-id", currentField),
                        [],
                        "No data available"
                    );
                },
            });
        } else {
            getScopedField("#field-1-student-id", currentField).empty();
        }
    });

    // Event handler for student ID change to fetch details
    $(document).on("change", "#field-1-student-id", function () {
        const studentId = $(this).val();
        const currentField = $(this);

        if (studentId) {
            $.ajax({
                url: "/student/academic-details",
                type: "GET",
                data: { student_id: studentId },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        getScopedField(
                            "#field-8-old-academic-year",
                            currentField
                        ).val(data.academic_year);
                    } else {
                        alertModal("Failed to retrieve student details.");
                    }
                },
                error: function () {
                    alertModal(
                        "An error occurred while retrieving student details."
                    );
                },
            });
        } else {
            getScopedField("#field-8-old-academic-year", currentField).val("");
        }
    });
    // Triggered when new academic level changes
    $(document).on(
        "change",
        "#field-7-student-academic-level-new",
        function () {
            const academicLevelId = $(this).val();
            const currentField = $(this); // Preserve the current field context

            if (academicLevelId) {
                $.ajax({
                    url: "/classrooms/by-academic-level",
                    type: "GET",
                    data: { academic_level_id: academicLevelId },
                    success: function (data) {
                        const classroomNewField = getScopedField(
                            "#field-8-student-classroom-new",
                            currentField
                        );
                        classroomNewField.empty();
                        if (data.length > 0) {
                            data.forEach(function (classroom) {
                                classroomNewField.append(
                                    $("<option>", {
                                        value: classroom.id,
                                        text: classroom.name,
                                    })
                                );
                            });
                            classroomNewField.trigger("change");
                        } else {
                            classroomNewField.append(
                                $("<option>", {
                                    value: "",
                                    text: "No classrooms available",
                                })
                            );
                        }
                    },
                    error: function () {
                        alert("Failed to retrieve classrooms.");
                    },
                });
            }
        }
    );

    // Triggered when new classroom changes
    $(document).on("change", "#field-8-student-classroom-new", function () {
        const classroomId = $(this).val();
        const currentField = $(this); // Preserve the current field context

        if (classroomId) {
            $.ajax({
                url: "/sections",
                type: "GET",
                data: { id: classroomId },
                success: function (data) {
                    const sectionNewField = getScopedField(
                        "#field-9-student-section-new",
                        currentField
                    );
                    sectionNewField.empty();
                    if (data.success && data.sections.length > 0) {
                        data.sections.forEach(function (section) {
                            sectionNewField.append(
                                $("<option>", {
                                    value: section.id,
                                    text: section.name,
                                })
                            );
                        });
                    } else {
                        sectionNewField.append(
                            $("<option>", {
                                value: "",
                                text: "No sections available",
                            })
                        );
                    }
                },
                error: function () {
                    alert("Failed to retrieve sections.");
                },
            });
        }
    });

    // for the new promotions ajax  to load the classrooms and sections consequently ends
    $("#classrooms-list").on("click", ".classroom-link", function (e) {
        e.preventDefault();
        let classroomId = $(this).data("id");
        window.location.href = "/sections?id=" + classroomId;
    });

    //all sections based on the selected classroom
    $("#load-classrooms").on("click", function () {
        let fetchUrl = $(this).data("url");
        $.ajax({
            url: fetchUrl,
            type: "GET",
            dataType: "json",
            success: function (response) {
                $("#classrooms-list").empty();
                if (Array.isArray(response) && response.length > 0) {
                    $.each(response, function (index, classroom) {
                        $("#classrooms-list").append(
                            '<li><a href="#" class="classroom-link" data-id="' +
                                classroom.id +
                                '">' +
                                classroom.name +
                                "</a></li>"
                        );
                    });
                } else {
                    $("#classrooms-list").append(
                        "<li>No classrooms available.</li>"
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching classrooms:", status, error);
                alert(
                    "An error occurred while loading the classrooms. Please try again."
                );
            },
        });
    });

    // Load sections for attendance based on the selected classroom
    $("#load-attendance-sections").on("click", function () {
       
        let fetchUrl = $(this).data("url");
        $.ajax({
            url: fetchUrl,
            type: "GET",
            dataType: "json",
            success: function (response) {
                $("#attendance-sections-list").empty();
                if (Array.isArray(response) && response.length > 0) {
                    $.each(response, function (index, section) {
                        $("#attendance-sections-list").append(
                            '<li><a href="#" class="attendance-section-link" data-id="' +
                                section.id +
                                '">' +
                                section.name +
                                "</a></li>"
                        );
                    });
                } else {
                    $("#attendance-sections-list").append(
                        "<li>No sections available.</li>"
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error(
                    "Error fetching sections for attendance:",
                    status,
                    error
                );
                alert(
                    "An error occurred while loading the sections for attendance. Please try again."
                );
            },
        });
    });

    // Navigate to the attendance page for the selected section
    $("#attendance-sections-list").on(
        "click",
        ".attendance-section-link",
        function (e) {
            e.preventDefault();
            let sectionId = $(this).data("id");
            window.location.href = "/attendance/" + sectionId;
        }
    );

    // Reusable function to show alert modal
    function alertModal(message) {
        $("#danger-alert-message").text(message);
        $("#danger-alert-modal").modal("show");
    }
});
