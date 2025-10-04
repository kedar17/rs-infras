<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
	DashboardController,
	ClientController,
	UserController,
	ProjectController,
	MaterialController,
	BudgetPlanController,
    ExpenseTrackController,
    FinanceBillingController,
    PaymentSettlementComtroller,
    TaskController,ContactController,
	ProposalController
};
use Illuminate\Console\View\Components\Task;

Route::middleware(['auth'])->group(function () {
	Route::get('/', [DashboardController::class, 'index']);
	Route::post('/dashboard/filter-tasks', [DashboardController::class, 'filterTasks'])->name('filter-tasks');
	//Route::post('/filter-tasks', [DashboardController::class, 'filterTasks'])
    // ->name('filter-tasks');


	Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
	Route::post('add-contact', [ContactController::class, 'addContact'])->name('add-contact');
	Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
	Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

	Route::get('/clients', [ClientController::class, 'index'])->name('clients');
	Route::post('add-client', [ClientController::class, 'addClient'])->name('add-client');
	Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
	Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');

	Route::get('/users', [UserController::class, 'index'])->name('users');
	Route::post('add-user', [UserController::class, 'addUser'])->name('add-user');
	Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
	Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
	

	Route::get('projects', [ProjectController::class, 'index'])->name('projects');
	Route::get('/projects/{id}', [ProjectController::class, 'projectDetails'])->name('projects.details');
	Route::post('add-project', [ProjectController::class, 'addProject'])->name('add-project');
	Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
	Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
	//Daily Project log
	Route::post('add-work-log', [ProjectController::class, 'addDailyWorkLog'])->name('add-work-log');

	Route::put('/work-log/{log}', [ProjectController::class, 'updateWorkLog'])->name('work_log.update');
	Route::delete('/work-log/{id}', [ProjectController::class, 'destroyWorkLog'])->name('daily_work_logs.destroy');

	Route::get('task-management', [TaskController::class, 'index'])->name('task-management');
	Route::post('add-task', [TaskController::class, 'addTask'])->name('add-task');
	Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
	Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

	Route::get('materials', [MaterialController::class, 'index'])->name('materials');
	Route::post('add-material', [MaterialController::class, 'addmaterials'])->name('add-material');
	Route::get('/materials/filter', [MaterialController::class, 'filterMaterial'])->name('filter-material');
	Route::put('/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
	Route::delete('/materials/{id}', [MaterialController::class, 'destroy'])->name('materials.destroy');

	Route::get('budget-planning', [BudgetPlanController::class, 'index'])->name('budget-planning');
	Route::post('add-budget', [BudgetPlanController::class, 'addBudget'])->name('add-budget');
	Route::get('/budget/filter', [BudgetPlanController::class, 'filterBudget'])->name('filter-budget');
	Route::put('/budget/{budget}', [BudgetPlanController::class, 'update'])->name('budget.update');
	Route::delete('/budget/{id}', [BudgetPlanController::class, 'destroy'])->name('budgets.destroy');

	Route::get('expense-track', [ExpenseTrackController::class, 'index'])->name('expense-track');
	Route::post('add-expense', [ExpenseTrackController::class, 'addExpense'])->name('add-expense');
	Route::get('/expense/filter', [ExpenseTrackController::class, 'filterExpense'])->name('filter-expense');
	Route::put('/expense/{expense}', [ExpenseTrackController::class, 'update'])->name('expense.update');
	Route::delete('/expense/{id}', [ExpenseTrackController::class, 'destroy'])->name('expenses.destroy');

	//finance & billing
	Route::get('finance-billing', [FinanceBillingController::class, 'index'])->name('finance-billing');
	Route::post('add-billing', [FinanceBillingController::class, 'addBilling'])->name('add-billing');
	Route::get('/billing/filter', [FinanceBillingController::class, 'filterBilling'])->name('filter-billing');
	Route::put('/billing/{billing}', [FinanceBillingController::class, 'update'])->name('billing.update');
	Route::delete('/billing/{id}', [FinanceBillingController::class, 'destroy'])->name('billings.destroy');
	
	//Route::get('finance-billing', [FinanceBillingController::class, 'index']);

	//Route::get('payment-settlement', [PaymentSettlementComtroller::class, 'index']);

	Route::get('payment-settlement', [PaymentSettlementComtroller::class, 'index'])->name('payment-settlement');
	Route::post('add-settlement', [PaymentSettlementComtroller::class, 'addSettlement'])->name('add-settlement');
	Route::get('/settlement/filter', [PaymentSettlementComtroller::class, 'filterSettlement'])->name('filter-settlement');
	Route::put('/settlement/{settlement}', [PaymentSettlementComtroller ::class, 'update'])->name('settlement.update');
	Route::delete('/settlement/{id}', [PaymentSettlementComtroller::class, 'destroy'])->name('settlements.destroy');

	Route::get('proposals', [ProposalController::class, 'index'])->name('proposals');
	Route::get('proposals/create', [ProposalController::class, 'create'])->name('proposals.create');
	Route::post('add-proposal', [ProposalController::class, 'addProposal'])->name('add-proposal');
	Route::get('proposals/{proposal}', [ProposalController::class, 'show'])->name('proposals.show');

	Route::get('proposals/{proposal}/download', [ProposalController::class, 'download'])->name('proposals.download');
	// Show edit form
	Route::get('proposals/{proposal}/edit', [ProposalController::class, 'edit'])->name('proposals.edit');
	// Handle update
	Route::put('proposals/{proposal}', [ProposalController::class, 'update'])->name('proposals.update');
	Route::delete('/proposals/{id}', [ProposalController::class, 'destroy'])->name('proposals.destroy');
	
	Route::post('/logout', [UserController::class, 'logout'])
		->name('logout')
		->middleware('auth');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
