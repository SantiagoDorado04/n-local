<?php

use GuzzleHttp\Client;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendSmsController;
use App\Http\Controllers\CkeditorController;
use App\Http\Livewire\Admin\Faqs\FaqsComponent;
use App\Http\Livewire\Contacts\LMS\LmsComponent;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Http\Livewire\Admin\Auth\SignUpComponent;
use App\Http\Livewire\Admin\Steps\StepsComponent;
use App\Http\Livewire\Admin\Tasks\TasksComponent;
use App\Http\Livewire\Admin\Canvas\CanvasComponent;
use App\Http\Livewire\Admin\Stages\StagesComponent;
use App\Http\Livewire\Admin\Support\SupportComponent;
use App\Http\Livewire\Admin\Viability\ScaleComponent;
use App\Http\Livewire\Contacts\StepsContactComponent;
use App\Http\Livewire\Interviews\InterviewsComponent;
use App\Http\Livewire\Admin\Faqs\FaqsContentComponent;
use App\Http\Livewire\Admin\Viability\ImpactComponent;
use App\Http\Livewire\Admin\Contacts\ContactsComponent;
use App\Http\Livewire\Admin\LMS\Topics\TopicsComponent;
use App\Http\Livewire\Admin\Meetings\MeetingsComponent;
use App\Http\Livewire\Admin\Mentoring\MentorsComponent;
use App\Http\Livewire\Admin\Projects\ProjectsComponent;
use App\Http\Livewire\Admin\Stages\PostulatesComponent;
use App\Http\Livewire\Contacts\LMS\LmsContentComponent;
use App\Http\Livewire\Admin\Forms\ExternalFormComponent;
use App\Http\Livewire\Admin\LMS\Courses\CoursesComponent;
use App\Http\Livewire\Admin\LMS\Lessons\LessonsComponent;
use App\Http\Livewire\Admin\Processes\ProcessesComponent;
use App\Http\Livewire\Admin\Viability\ViabilityComponent;
use App\Http\Livewire\Contacts\ProcessesContactComponent;
use App\Http\Livewire\Admin\Profile\UsersProfileComponent;
use App\Http\Livewire\Admin\Viability\InnovationComponent;
use App\Http\Livewire\Admin\Challenges\ChallengesComponent;
use App\Http\Livewire\Interviews\InterviewsCreateComponent;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Livewire\Admin\Contacts\ContactsCloudComponent;
use App\Http\Livewire\Admin\Contacts\ContactsFormsComponent;
use App\Http\Livewire\Interviews\InterviewsAnswersComponent;
use App\Http\Controllers\Admin\Companies\CompaniesController;
use App\Http\Controllers\Admin\Projects\ProjectMapController;
use App\Http\Livewire\Admin\Mentoring\ListMentoringComponent;
use App\Http\Livewire\Admin\MentorsList\MentorsListComponent;
use App\Http\Livewire\Admin\SelfManagement\ProblemsComponent;
use App\Http\Livewire\Admin\Profile\CompaniesProfileComponent;
use App\Http\Livewire\Admin\SelfManagement\SolutionsComponent;
use App\Http\Livewire\Contacts\Canvas\CanvasContactsComponent;
use App\Http\Livewire\Interviews\InterviewsQuestionsComponent;
use App\Http\Livewire\Admin\Canvas\CanvasContactsListComponent;
use App\Http\Livewire\Admin\LMS\Lessons\LessonContentComponent;
use App\Http\Livewire\Admin\SelfManagement\IndicatorsComponent;
use App\Http\Controllers\Admin\Mailing\MailingMassiveController;
use App\Http\Controllers\Admin\OnlineRegistrationsDocuments\OnlineRegistrationDocumentsController;
use App\Http\Livewire\Admin\Announcements\AnnouncementComponent;
use App\Http\Livewire\Admin\Challenges\ChallengesFilesComponent;
use App\Http\Livewire\Interviews\InterviewsWhiteLabelsComponent;
use App\Http\Livewire\Admin\BusinessModel\BusinessModelComponent;
use App\Http\Livewire\Admin\Proposals\ProposalQuestionsComponent;
use App\Http\Livewire\Admin\Proposals\ProposalTemplatesComponent;
use App\Http\Livewire\Admin\SelfManagement\MetodologiesComponent;
use App\Http\Livewire\Admin\TaskSchedules\TaskSchedulesComponent;
use App\Http\Livewire\Admin\Proposals\ProposalManagementComponent;
use App\Http\Livewire\Admin\CommercialLand\CommercialLandComponent;
use App\Http\Livewire\Admin\Mentoring\MentorsAvailabilityComponent;
use App\Http\Livewire\Admin\SelfManagement\SelfManagementComponent;
use App\Http\Livewire\Admin\Videotutorials\VideotutorialsComponent;
use App\Http\Livewire\Admin\Announcements\AnnouncementFormComponent;
use App\Http\Livewire\Admin\CommercialForms\CommercialFormComponent;
use App\Http\Livewire\Admin\SelfManagement\ProjectsCompanyComponent;
use App\Http\Livewire\Contacts\Mentoring\MentoringContactsComponent;
use App\Http\Controllers\Admin\Proposals\ProposalTemplatesController;
use App\Http\Controllers\TestJobController;
use App\Http\Livewire\Admin\LMS\Courses\CoursesParticipantsComponent;
use App\Http\Livewire\Admin\CommercialAction\SocialQuestionsComponent;
use App\Http\Livewire\Admin\CommercialForms\CommercialOptionComponent;
use App\Http\Livewire\Contacts\Challenges\ChallengesContactsComponent;
use App\Http\Livewire\Contacts\Interviews\InterviewsContactsComponent;
use App\Http\Livewire\Admin\Characterization\CharacterizationComponent;
use App\Http\Livewire\Admin\CommercialAction\CommercialActionComponent;
use App\Http\Livewire\Admin\ContactSchedules\ContactSchedulesComponent;
use App\Http\Livewire\Admin\InformationForms\InformationFormsComponent;
use App\Http\Livewire\Admin\ProductsServices\ProductsServicesComponent;
use App\Http\Livewire\Admin\CommercialForms\CommercialQuestionComponent;
use App\Http\Livewire\Admin\ContactSchedules\CalendarSchedulesComponent;
use App\Http\Livewire\Admin\MessageManagement\MessageManagementComponent;
use App\Http\Livewire\Admin\Announcements\AnnouncementFormOptionComponent;
use App\Http\Livewire\Admin\CommercialForms\CommercialFormActionComponent;
use App\Http\Livewire\Admin\CommercialForms\CommercialFormPreviewComponent;
use App\Http\Livewire\Admin\CommercialStrategy\CommercialStrategyComponent;
use App\Http\Livewire\Admin\CommercialForms\CommercialFormContactsComponent;
use App\Http\Livewire\Admin\CommercialAction\MessageManagementActionComponent;
use App\Http\Livewire\Admin\InformationForms\InformationFormsOptionsComponent;
use App\Http\Livewire\Admin\PresentialActivities\PresentialActivitiesComponent;
use App\Http\Livewire\Admin\SocialEngineering\ConfigSocialEnginneringComponent;
use App\Http\Livewire\Admin\InformationForms\InformationFormsQuestionsComponent;
use App\Http\Livewire\Admin\SocialEngineering\ProcessSocialEnginneringComponent;
use App\Http\Livewire\Contacts\PresentialActivities\ContactsActivitiesComponent;
use App\Http\Livewire\Admin\AnnouncementsContatcs\AnnouncementsContactsComponent;
use App\Http\Livewire\Contacts\InformationForms\InformationFormsContactsComponent;
use App\Http\Livewire\Admin\PresentialActivities\PresentialActivitiesGroupsComponent;
use App\Http\Livewire\Admin\CommercialManagement\MailingMassive\MailingMassiveComponent;
use App\Http\Livewire\Admin\ContactsForms\ContactsFormsComponent as ContactAssignedForms;
use App\Http\Livewire\Admin\PresentialActivities\PresentialActivitiesParticipantsComponent;
use App\Http\Livewire\Admin\CommercialManagement\MailingTemplates\MailingTemplatesComponent;
use App\Http\Livewire\Admin\CommercialManagement\MailingIndividual\MailingIndividualComponent;
use App\Http\Livewire\Admin\CommercialManagement\MailingMassive\HistoryMailingMassiveComponent;
use App\Http\Livewire\Admin\CommercialManagement\MailingMassive\ContactsMailingMassiveComponent;
use App\Http\Livewire\Admin\CommercialManagement\MailingTemplates\CreateMailingTemplatesComponent;
use App\Http\Livewire\Admin\InformationForms\ExternalFormComponent as ExternalInformationComponent;
use App\Http\Livewire\Admin\CommercialManagement\MailingIndividual\HistoryMailingIndividualComponent;
//-----
use App\Http\Livewire\Admin\OnlineRegistrations\OnlineRegistrationsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCategories\OnlineRegistrationCategoriesComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\OnlineRegistrationCoursesComponent;
use App\Http\Livewire\Admin\OnlineRegistrationForms\OnlineRegistrationFormQuestionsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationForms\OnlineRegistrationFormOptionsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\OnlineRegistrationContactsCoursesComponent;
use App\Http\Livewire\Admin\OnlineRegistrationForms\OnlineRegistrationPublicFormComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationCoursesSessionsComponent;
//asistencias
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Attendees\OnlineRegistrationCoursesAttendeesComponent;

use App\Http\Livewire\Admin\CourseRegistrationForms\AttendeeRegistrationComponent;
use App\Http\Livewire\Admin\CourseRegistrationForms\CourseRegistrationFormsComponent;
use App\Http\Livewire\Admin\Reports\TrainingReport\TrainingReportComponent;
use App\Http\Livewire\Admin\InformationForms\ExternalRegistrationFormComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCharacterizations\OnlineRegistrationCharacterizationsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCharacterizations\OrCharacterizationAnswers\OrCharacterizationAnswersComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCharacterizations\OrCharacterizationOptions\OrCharacterizationOptionsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCharacterizations\OrCharacterizationQuestions\OrCharacterizationQuestionsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\OnlineRegistrationCertificateEmails\OnlineRegistrationCertificateEmailsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\OnlineRegistrationCoursesCertificateComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\OnlineRegistrationCoursesComunicationComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\OnlineRegistrationDocuments\OnlineRegistrationDocumentsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\OrCoursesComunicationComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents\DetailsLessons\OnlineRegistrationLessonDetailsCreateComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents\DetailsLessons\OnlineRegistrationLessonDetailsEditComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents\DetailsLessons\OnlineRegistrationLessonsContentsDetailsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents\OnlineRegistrationLessonContentsEditComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents\OnlineRegistrationLessonsContentsCreateComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents\OnlineRegistrationLessonsContentsPreviewComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\LessonsContents\OnlineRegistrationLessonsContentstCreateComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\OnlineRegistrationSessionContentsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\OnlineRegistratioSessionContentsPreviewComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\SlideContents\OnlineRegistrationSlideContentsCreateComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\SlideContents\OnlineRegistrationSlideContentsEditComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\SlideContents\OnlineRegistrationSlideContentsPreviewComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents\OnlineRegistrationTestChoices\OnlineRegistrationTestChoicesComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents\OnlineRegistrationTestContentsCreateComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents\OnlineRegistrationTestContentsEditComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents\OnlineRegistrationTestContentsPreviewComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents\OnlineRegistrationTestContentsResultsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents\OnlineRegistrationTestItems\OnlineRegistrationTestItemsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\TestContents\OnlineRegistrationTestResponses\OnlineRegistrationTestResponsesComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\VideosContents\OnlineRegistrationVideosContentsComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\VideosContents\OnlineRegistrationVideosContentsCreateComponent;
use App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents\VideosContents\OnlineRegistrationVideosContentsEditComponent;
use App\Http\Livewire\Admin\ProcessAlquimiaAgent\Sessions\OnlineRegistrationSessionContents\VideosContents\OnlineRegistrationVideosContentsPreviewComponent;
use App\Http\Livewire\Admin\OnlineRegistrations\OnlineRegistrationChannelComponent;
use App\Http\Livewire\Admin\OnlineRegistrations\OnlineRegistrationExternalExecutionsComponent;
use App\Http\Livewire\Contacts\MyOnlineRegistrationCourses\MyOnlineRegistrationCoursesComponent;
use App\Http\Livewire\Contacts\MyOnlineRegistrationCourses\OrMyCourseSessions\OrMyCharacterizations\OrMyCharacterizationsComponent;
use App\Http\Livewire\Contacts\MyOnlineRegistrationCourses\OrMyCourseSessions\OrMyCharacterizations\OrMyCharacterizationsDiligences\OrMyCharacterizationsDiligencesComponent;
use App\Http\Livewire\Contacts\MyOnlineRegistrationCourses\OrMyCourseSessions\OrMyCourseSessionsComponent;
use App\Http\Livewire\Contacts\MyOnlineRegistrationCourses\OrMyCourseSessions\OrMySessionContents\OrMySessionContentsComponent;
use App\Http\Livewire\Admin\MyOnlineRegistrationCourses\OrMyCourseSessions\OrMySessionContents\OrMySessionContentsComponent;
use App\Models\OnlineRegistration;
use App\Models\OnlineRegistrationChannel;
use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationSessionContent;
use App\Models\OnlineRegistrationTestChoice;
use App\Models\OnlineRegistrationTestItem;
use App\Models\OnlineRegistrationVideoContent;
use App\Models\OrCourseComunication;

Route::get('/', function () {
    return view('welcome2');
})->name('home.auth');

Route::get('/image', function () {
    return view('example');
});

Route::get('/admin/map', function () {
    return view('mind');
});


Route::get('signup', SignUpComponent::class)->name('signup');

/* External Form */
Route::get('form/{token}', ExternalFormComponent::class)->name('commercial.form-external');

Route::get('external-form/{token}', ExternalInformationComponent::class)->name('information-form.form-external');

/* CKEditor upload files */
Route::post('/ckeditor/image_upload', [CkeditorController::class, 'upload'])->name('upload');

/* email */
Route::get('update-read', [MailingMassiveController::class, 'updatedRead'])->name('update-read');
Route::get('update-read-massive', [MailingMassiveController::class, 'updatedReadMassive'])->name('update-read-massive');
Route::get('update-click', [MailingMassiveController::class, 'updatedClick'])->name('update-click');

Route::group(['prefix' => 'admin'], function () {

    Voyager::routes();

    Route::group(['middleware' => 'admin'], function () {


        //ADMIN

        /* Perfíl empresa */
        Route::get('profile-company', CompaniesProfileComponent::class)->name('company.profile');

        /* Planificación Terreno Comercial */
        Route::get('commercial-lands', CommercialLandComponent::class)->name('commercial.lands');
        Route::get('commercial-lands/{land}/strategies', CommercialStrategyComponent::class)->name('commercial.strategies');
        Route::get('commercial-lands/{strategy}/actions', CommercialActionComponent::class)->name('commercial.actions');
        Route::get('commercial-lands/{action}/questions', SocialQuestionsComponent::class)->name('commercial.actions.questions');
        Route::get('commercial-lands/{action}/messages', MessageManagementActionComponent::class)->name('commercial.actions.messages');

        /* Widget simulador */
        Route::get('forms', CommercialFormComponent::class)->name('commercial.forms');
        Route::get('forms/{form}/questions', CommercialQuestionComponent::class)->name('commercial.questions');
        Route::get('forms/{question}/options', CommercialOptionComponent::class)->name('commercial.options');
        Route::get('forms/{form}/form-preview', CommercialFormPreviewComponent::class)->name('commercial.form-preview');

        Route::get('forms/{form}/actions', CommercialFormActionComponent::class)->name('commercial.form-action');
        Route::get('forms/{action}/contacts', CommercialFormContactsComponent::class)->name('commercial.form-contacts');

        Route::get('characterization', CharacterizationComponent::class)->name('characterization');

        /* Convocatorias */
        Route::get('announcements', AnnouncementComponent::class)->name('announcements');
        Route::get('announcements/{announcement}/forms', AnnouncementFormComponent::class)->name('announcement.forms');
        Route::get('announcements/{form}/form-options', AnnouncementFormOptionComponent::class)->name('announcement.form-options');

        /* Contactos */
        Route::get('contacts', ContactsComponent::class)->name('commercial.contacts');
        Route::get('contacts-cloud', ContactsCloudComponent::class)->name('commercial.contacts-cloud');
        Route::get('contacts-cloud/{id}/forms', ContactsFormsComponent::class)->name('commercial.contacts-cloud.form');

        /* Ingeniería social */
        Route::get('questions-social-engineering', ConfigSocialEnginneringComponent::class)->name('social-engineering.config');
        Route::get('social-engineering', ProcessSocialEnginneringComponent::class)->name('social-engineering.process');

        /* Perfíl de contacto */
        Route::get('profiles/{contact}', UsersProfileComponent::class)->name('users.profile');

        /* Mensajes de valor */
        Route::get('message-management', MessageManagementComponent::class)->name('message-management');
        /* Registro de tareas */
        Route::get('tasks', TasksComponent::class)->name('tasks');
        /* Registro de agendamientos */
        Route::get('meetings', MeetingsComponent::class)->name('meetings');

        /* Gestión plantillas de correo */
        Route::get('mailing-templates', MailingTemplatesComponent::class)->name('mailing.templates');
        Route::get('mailing-templates/template/{template?}', CreateMailingTemplatesComponent::class)->name('mailing.templates.add');

        /* Mailing */
        Route::get('mailing-individual/{id?}', MailingIndividualComponent::class)->name('mailing.individual');
        Route::get('single-outbox', HistoryMailingIndividualComponent::class)->name('mailing.individual.outbox');


        Route::get('mailing-massive/{id?}', MailingMassiveComponent::class)->name('mailing.massive');
        Route::get('massive-outbox', HistoryMailingMassiveComponent::class)->name('mailing.massive.outbox');
        Route::get('massive-outbox/{id}/contacts', ContactsMailingMassiveComponent::class)->name('mailing.massive.contacts');

        //AGENT

        /* Planificación de tareas(Agente) */
        Route::get('contact-schedules', ContactSchedulesComponent::class)->name('contacts-schedules');
        Route::get('contact-schedules/calendar', CalendarSchedulesComponent::class)->name('contacts-schedules.calendar');
        Route::get('task-schedules', TaskSchedulesComponent::class)->name('task-schedules');

        //Projects

        Route::get('projects', ProjectsComponent::class)->name('projects');
        Route::get('projects/{id}/viability', [CompaniesController::class, 'viability'])->name('viability');
        Route::get('projects/{id}/innovation', [CompaniesController::class, 'innovation'])->name('innovation');
        Route::get('projects/{id}/scale', [CompaniesController::class, 'scale'])->name('scale');
        Route::get('projects/{id}/impact', [CompaniesController::class, 'impact'])->name('impact');
        Route::get('projects/{project}/map', [ProjectMapController::class, 'index'])->name('projects.map');


        //SELF MANAGEMENT

        Route::get('self-management', SelfManagementComponent::class)->name('self-management');
        Route::get('self-management/{announcement}/projects/{project?}', ProjectsCompanyComponent::class)->name('projects.user');
        Route::get('self-management/{project}/problems', ProblemsComponent::class)->name('problems');
        Route::get('self-management/{problem}/solutions', SolutionsComponent::class)->name('solutions');
        Route::get('self-management/{solution}/metodologies', MetodologiesComponent::class)->name('metodologies');
        Route::get('self-management/{metodology}/indicators', IndicatorsComponent::class)->name('indicators');


        //Companies
        Route::get('my-forms', ContactAssignedForms::class)->name('contacts.my-forms');
        Route::get('products-services', ProductsServicesComponent::class)->name('contacts.products-services');
        Route::get('business-models', BusinessModelComponent::class)->name('contacts.business-models');

        Route::get('my-forms/form/{form}/action/{action}/contact/{contact_id?}', AnnouncementsContactsComponent::class)->name('contacts.my-forms.announcements');

        Route::get('viability-check', ViabilityComponent::class)->name('contacts.viability');
        Route::get('viability-check/{project}/innovation', InnovationComponent::class)->name('contacts.viability.innovation');
        Route::get('viability-check/{project}/scale', ScaleComponent::class)->name('contacts.viability.scale');
        Route::get('viability-check/{project}/viability', ImpactComponent::class)->name('contacts.viability.impact');

        Route::get('proposal-templates', ProposalTemplatesComponent::class)->name('proposal.templates');
        Route::get('proposal-templates/{id}/questions', ProposalQuestionsComponent::class)->name('proposal.questions');


        Route::get('proposal-templates/create', [ProposalTemplatesController::class, 'create'])->name('proposal.templates.create');
        Route::post('proposal-templates/create', [ProposalTemplatesController::class, 'store'])->name('proposal.templates.store');

        Route::get('proposals', ProposalManagementComponent::class)->name('proposal.management');

        //FAQS
        Route::get('faqs', FaqsComponent::class)->name('faqs');
        Route::get('faqs/{id}/content', FaqsContentComponent::class)->name('faqs-content');
        Route::get('support', SupportComponent::class)->name('support');
        Route::get('videotutorials', VideotutorialsComponent::class)->name('videotutorials');

        //Company Detalle
        Route::get('company-detail/{id}', [CompaniesController::class, 'infoCompany'])->name('companies.detail');
        Route::get('company-products-services/{id}', [CompaniesController::class, 'productsServices'])->name('companies.products-services');
        Route::get('company-assigned-forms/{id}', [CompaniesController::class, 'assignedForms'])->name('companies.assigned-forms');
        Route::get('company-answers-form/{id}', [CompaniesController::class, 'answersForm'])->name('companies.answers-form');
        Route::get('company-business-models/{id}', [CompaniesController::class, 'businessModels'])->name('companies.business-models');


        Route::get('processes', ProcessesComponent::class)->name('processes');
        Route::get('processes/{id}/stages', StagesComponent::class)->name('stages');
        Route::get('stages/{id}/steps', StepsComponent::class)->name('steps');
        Route::get('stages/{id}/postulates', PostulatesComponent::class)->name('stages.postulates');


        Route::get('step/{id}/information-forms', InformationFormsComponent::class)->name('information-forms');
        Route::get('step/{id}/courses', CoursesComponent::class)->name('courses');
        Route::get('courses/{id}/topics', TopicsComponent::class)->name('topics');
        Route::get('courses/{id}/participants', CoursesParticipantsComponent::class)->name('courses.participants');
        Route::get('topics/{id}/lessons', LessonsComponent::class)->name('lessons');
        Route::get('lessons/{id}/content', LessonContentComponent::class)->name('lessons.content');

        Route::get('step/{id}/presential-activities', PresentialActivitiesComponent::class)->name('presential-activities');
        Route::get('presential-activities/{id}/groups', PresentialActivitiesGroupsComponent::class)->name('presential-activities-groups');
        Route::get('groups/{id}/participants', PresentialActivitiesParticipantsComponent::class)->name('presential-activities-groups.participants');

        Route::get('information-forms/{id}/questions', InformationFormsQuestionsComponent::class)->name('information-forms-questions');
        Route::get('information-questions/{id}/options', InformationFormsOptionsComponent::class)->name('information-forms-options');
        Route::get('information-questions/{id}/answers', PostulatesComponent::class)->name('information-forms.answers');

        Route::get('step/{id}/challenges', ChallengesComponent::class)->name('challenges');
        Route::get('challenges/{id}/files', ChallengesFilesComponent::class)->name('challenges.files');

        Route::get('step/{id}/mentoring', MentorsComponent::class)->name('mentoring');
        Route::get('mentoring/{id}/availability', MentorsAvailabilityComponent::class)->name('mentoring.availability');
        Route::get('mentoring/{id}/list', ListMentoringComponent::class)->name('mentoring.list');


        Route::get('step/{id}/canvas', CanvasComponent::class)->name('canvas');
        Route::get('canvas/{id}/contacts', CanvasContactsListComponent::class)->name('canvas-contactList');

        Route::get('step/{id}/video-interviews/create', InterviewsCreateComponent::class)->name('video-interviews');
        Route::get('step/{guid}/video-interviews/update', InterviewsQuestionsComponent::class)->name('video-interviews.update');
        Route::get('step/{guid}/video-interviews/answers', InterviewsAnswersComponent::class)->name('video-interviews.answers');

        //AlquimIA Agent

        Route::get('step/{id}/alquimia-agent', ProcessAlquimiaAgentComponent::class)->name('process-alquimia-agent');

        //Contacts
        Route::get('my-processes', ProcessesContactComponent::class)->name('processes.contact');
        Route::get('my-processes/{id}/steps', StepsContactComponent::class)->name('steps.contact');

        Route::get('steps-contacts/{id}/information-form', InformationFormsContactsComponent::class)->name('information-forms.contact');
        Route::get('steps-contacts/{id}/challenges', ChallengesContactsComponent::class)->name('challenges.contact');
        Route::get('steps-contacts/{id}/mentoring', MentoringContactsComponent::class)->name('mentoring.contact');
        Route::get('steps-contacts/{id}/presential-activities', ContactsActivitiesComponent::class)->name('presential-activities.contact');
        Route::get('steps-contacts/{id}/courses', LmsComponent::class)->name('lms.contact');
        Route::get('steps-contacts/{id}/canvas', CanvasContactsComponent::class)->name('canvas.contact');
        Route::get('steps-contacts/{id}/video-interviews', InterviewsContactsComponent::class)->name('video-interviews.contact');

        Route::get('courses/{id}/content', LmsContentComponent::class)->name('lms-content.contact');

        Route::get('mentors', MentorsListComponent::class)->name('mentors');
        Route::get('interviews', InterviewsComponent::class)->name('interviews');
        Route::get('interviews/{guid}/questions', InterviewsQuestionsComponent::class)->name('interviews.questions');
        Route::get('interviews/{guid}/answers', InterviewsAnswersComponent::class)->name('interviews.answers');
        Route::get('interviews/create', InterviewsCreateComponent::class)->name('interviews.create');

        Route::get('interviews/white-labels', InterviewsWhiteLabelsComponent::class)->name('interviews.white-labels');

        //rutas de modulo de control de registro

        Route::get('online-registrations', OnlineRegistrationsComponent::class)->name('online-registrations');
        Route::get('online-registrations/{id}/channels', OnlineRegistrationChannelComponent::class)->name('online-registrations-channels');
        Route::get('online-registrations/{id}/categories', OnlineRegistrationCategoriesComponent::class)->name('online-registration-categories');
        Route::get('online-registrations/categories/{id}/courses', OnlineRegistrationCoursesComponent::class)->name('online-registration-courses');

        //Or_ddocuments
        Route::get('online-registrations/categories/courses/{id}/documents', OnlineRegistrationDocumentsComponent::class)->name('online-registration-documents');

        //Emails de registrados para certificados o documentos:
        Route::get('online-registrations/categories/courses/{courseId}/certificate/{id}/email', OnlineRegistrationCertificateEmailsComponent::class)
            ->name('or-certificate-email');



        //Caracterizations
        Route::get('online-registrations/categories/{id}/courses/courseComunication', OrCoursesComunicationComponent::class)->name('online-registration-courses-comunication');
        Route::get('online-registrations/channels/external-executions', OnlineRegistrationExternalExecutionsComponent::class)->name('online-registration-external-executions');
        Route::get('online-registrations/categories/courses/{id}/sessions', OnlineRegistrationCoursesSessionsComponent::class)->name('online-registration-courses-sessions');
        Route::get('online-registrations/categories/courses/sessions/characterization/{id}/preguntas', OrCharacterizationQuestionsComponent::class)->name('or-characterization-questions');
        Route::get('online-registrations/categories/courses/sessions/characterization/{id}/answer', OrCharacterizationAnswersComponent::class)->name('or-characterization-answers');

        //formulario de characterization
        Route::get('online-registrations/categories/courses/sessions/{id}/characterization', OnlineRegistrationCharacterizationsComponent::class)->name('online-registration-characterizations');

        //Contenidos
        Route::get('online-registrations/categories/courses/sessions/{id}/session-contents', OnlineRegistrationSessionContentsComponent::class)->name('online-registration-sessionContent');
        Route::get('online-registrations/categories/courses/sessions/{id}/session-contents-preview', OnlineRegistratioSessionContentsPreviewComponent::class)->name('online-registration-sessionContent-preview');

        //gestion de los contenidos de tipo video
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/video-content-create', OnlineRegistrationVideosContentsCreateComponent::class)->name('online-registration-video-content-create');
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/video-content-edit', OnlineRegistrationVideosContentsEditComponent::class)->name('online-registration-video-content-edit');
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/video-content-preview', OnlineRegistrationVideosContentsPreviewComponent::class)->name('online-registration-video-content-preview');

        //gestion de los contenidos de tipo leccion
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/lesson-content-create', OnlineRegistrationLessonsContentsCreateComponent::class)->name('online-registration-lesson-content-create');
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/Lessons-content-edit', OnlineRegistrationLessonContentsEditComponent::class)->name('online-registration-lesson-content-edit');
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/Lessons-content-preview', OnlineRegistrationLessonsContentsPreviewComponent::class)->name('online-registration-lesson-content-preview');
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/Lessons-content-detail', OnlineRegistrationLessonsContentsDetailsComponent::class)->name('online-registration-lesson-content-detail');
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/Lessons-content-detail-create', OnlineRegistrationLessonDetailsCreateComponent::class)->name('online-registration-lesson-content-detail-create');
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/Lessons-content-detail-edit', OnlineRegistrationLessonDetailsEditComponent::class)->name('online-registration-lesson-content-detail-edit');


        // gestion de los contenidos de tipo slide
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/slide-content-create', OnlineRegistrationSlideContentsCreateComponent::class)->name('online-registration-slide-content-create');
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/slide-content-edit', OnlineRegistrationSlideContentsEditComponent::class)->name('online-registration-slide-content-edit');
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/slide-content-preview', OnlineRegistrationSlideContentsPreviewComponent::class)->name('online-registration-slide-content-preview');

        //gestion de los contenidos de tipo test
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/test-content-create', OnlineRegistrationTestContentsCreateComponent::class)->name('online-registration-test-content-create');
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/test-content-edit', OnlineRegistrationTestContentsEditComponent::class)->name('online-registration-test-content-edit');
        Route::get('online-registrations/categories/courses/sessions/session-contents/test-content/{id}/test-items', OnlineRegistrationTestItemsComponent::class)->name('online-registration-test-items');
        Route::get('online-registrations/categories/courses/sessions/session-contents/test-content/test-items/{id}/test-choice', OnlineRegistrationTestChoicesComponent::class)->name('online-registration-test-choices');
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/test-content-preview', OnlineRegistrationTestContentsPreviewComponent::class)->name('online-registration-test-content-preview');
        Route::get('online-registrations/categories/courses/sessions/session-contents/{id}/test-content-result', OnlineRegistrationTestContentsResultsComponent::class)->name('online-registration-test-content-result');
        Route::get('online-registrations/categories/courses/sessions/characterization/{id}/questions', OrCharacterizationQuestionsComponent::class)->name('or-characterization-questions');
        Route::get('online-registrations/categories/courses/sessions/characterization/questions/{id}/options', OrCharacterizationOptionsComponent::class)->name('or-characterization-options');

        //formulario de registro:
        Route::get('online-registrations/categories/courses/{id}/questions', OnlineRegistrationFormQuestionsComponent::class)->name('online-registration-form-questions');
        Route::get('online-registrations/categories/courses/question/{id}/options', OnlineRegistrationFormOptionsComponent::class)->name('online-registration-form-options');

        //registros,asistencias y certificaciones:
        Route::get('online-registrations/categories/courses/{id}/contacts', OnlineRegistrationContactsCoursesComponent::class)->name('online-registration-contacts-courses');
        Route::get('online-registrations/categories/courses/{id}/certificate', OnlineRegistrationCoursesCertificateComponent::class)->name('online-registration-contacts-certificate');
        Route::get('online-registrations/categories/courses/{id}/attendees', OnlineRegistrationCoursesAttendeesComponent::class)->name('online-registration-courses-attendees');


        // En routes/web.php

        Route::get('online-registrations/categories/courses/certificate/{id}/download/{contactId}', [OnlineRegistrationDocumentsController::class, 'generarPDF'])->name('descargar.certificado');

        //rutas modulo de usuarios de online registrations

        Route::get('my-registrations', MyOnlineRegistrationCoursesComponent::class)->name('my-registrations');
        Route::get('my-registrations/{id}/my-course-sessions', OrMyCourseSessionsComponent::class)->name('my-course-sessions');
        Route::get('my-registrations/my-course-sessions/{id}/my-characterizations', OrMyCharacterizationsComponent::class)->name('my-or-characterizations');
        Route::get('my-registrations/my-course-sessions/my-characterizations/{id}/diligence', OrMyCharacterizationsDiligencesComponent::class)->name('my-or-characterization-diligence');
        Route::get('my-registrations/my-course-sessions/my-session-contents/{id}/content', OrMySessionContentsComponent::class)->name('my-or-session-contents');


        Route::get('online-registrations/{id}/training-reports', TrainingReportComponent::class)->name('training-reports');
        Route::get('online-registrations/{id}/course-regisration-forms', CourseRegistrationFormsComponent::class)->name('course-regisration-forms');
        Route::get('online-registrations/course-regisration-forms/{id}/attendees-registrations', AttendeeRegistrationComponent::class)->name('attendees.registrations');
    });
});

//nueva ruta de formulario externo de registro
Route::get('public-registration-form/{slug}', OnlineRegistrationPublicFormComponent::class)->name('online-registration-public-form');

Route::get('forget-password', [ResetPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ResetPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ResetPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
