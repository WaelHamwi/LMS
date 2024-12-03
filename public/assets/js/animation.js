$(function () {
    const $modal = $("#student-modal");
    const $overlay = $("#student-overlay");
    const $form = $("#student-form");

    let imagePreviewContainer;

    $("#add-student").on("click", () => {
        // clearForm();
        $("#image-preview-container").empty().hide();
        openModal();
        attachImageHandler();
    });

    $(".edit-student").on("click", function (event) {
        event.stopPropagation();
        attachImageHandler();
        clearForm();
        populateForm($(this).data());
        openModal();
        
    });

    $("#close-modal, #student-overlay").on("click", closeModal);

    $(document).on("click", (event) => {
        if (
            !$modal.is(event.target) &&
            $modal.has(event.target).length === 0 &&
            !$(event.target).is("#add-student")
        ) {
            closeModal();
        }
    });

    function openModal() {
        $overlay.fadeIn(300);
        $modal.fadeIn(300);
    }

    function closeModal() {
        $modal.fadeOut(300);
        $overlay.fadeOut(300);
    }

    function clearForm() {
        $form.trigger("reset");
        $form.attr("action", "{{ route('students.store') }}");
        $form.find('input[name="_method"]').remove();
        $("#image-preview-container").empty().hide();
    }

    function populateForm(data) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const fields = {
            name: $("#field-1-student-name"),
            email: $("#field-2-student-email"),
            gender: $("#field-3-student-gender"),
            blood: $("#field-4-student-blood"),
            nationality: $("#field-5-student-nationality"),
            dateOfBirth: $("#field-6-student-dob"),
            academicYear: $("#field-11-student-academic-year"),
        };

        fields.name.val(data.name);
        fields.email.val(data.email);
        fields.gender.val(data.gender).trigger("change");
        fields.blood.val(data.blood).trigger("change");
        fields.nationality.val(data.nationality).trigger("change");
        fields.dateOfBirth.val(data.dateOfBirth);
        fields.academicYear.val(data.academicYear);

        function selectDropdownByText(selectorId, text) {
            const dropdown = document.getElementById(selectorId);
            Array.from(dropdown.options).forEach((option) => {
                option.selected = option.text === text;
            });
        }

        selectDropdownByText(
            "field-7-student-academic-level",
            data.academicLevelId
        );
        selectDropdownByText("field-8-student-classroom", data.classroomId);
        selectDropdownByText("field-9-student-section", data.sectionId);
        selectDropdownByText("field-10-student-parent", data.parentId);

        $form.attr("method", "POST");
        $form.attr("action", `/students/${data.id}`);
        $form.append('<input type="hidden" name="_method" value="PUT">');
        $form.append(
            `<input type="hidden" name="_token" value="${csrfToken}">`
        );
    }

    function attachImageHandler(targetPreviewId) {
        const $imageInput = $(`#field-12-student-image-${targetPreviewId}`);
        $imageInput.off("change").on("change", handleImagePreview);

        const imageForm = $("#field-12-student-image");
        if (imageForm) {
            $("#field-12-student-image").on("change", function () {
                const files = this.files;
                if (files && files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = $("<img>")
                            .attr("src", e.target.result)
                            .addClass("preview-image");
                        $("#image-preview-container")
                            .empty()
                            .append(img)
                            .show();
                    };
                    reader.readAsDataURL(files[0]);
                }
            });
        }
    }

    function handleImagePreview(event) {
        imagePreviewContainer.show();
        imagePreviewContainer.empty();

        const files = event.target.files;
        Array.from(files).forEach((file) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const imagePreview = $(`
                    <div class="position-relative d-inline-block me-2">
                        <img src="${e.target.result}" style="max-width: 100px; max-height: 100px; margin: 5px;">
                        <button type="button" class="btn-close btn-danger position-absolute top-0 start-100 translate-middle" aria-label="Close"></button>
                    </div>
                `);
                imagePreviewContainer.append(imagePreview);

                // Close button functionality
                imagePreview.find(".btn-close").on("click", function () {
                    $(this).parent().remove();
                    if (imagePreviewContainer.children().length === 0) {
                        imagePreviewContainer.hide();
                        $("#newImageFilename").val(""); // Clear filename if no images left
                    }
                });
            };
            reader.readAsDataURL(file);
        });
    }

    // Event handler for the edit image button
    $(".edit-image").on("click", function () {
        let targetPreviewId = $(this)
            .data("bs-target")
            .replace("#", "")
            .split("-")[1];
        imagePreviewContainer = $(
            `#image-preview-container-${targetPreviewId}`
        );
        imagePreviewContainer.hide();

        const imageId = $(this).data("id");
        const filename = $(this).data("filename");
        const imageableId = $(this).data("imageable-id");
        const imageableType = $(this).data("imageable-type");
        const target = $(this).data("bs-target").replace("#", "");

        $("#imageEditModal #imageId").val(imageId);
        $("#imageEditModal #imageFilename").val(filename);
        $("#imageEditModal #imageableId").val(imageableId);
        $("#imageEditModal #imageableType").val(imageableType);

        attachImageHandler(targetPreviewId);
        $(`#${target}`).modal("show");
    });
});
