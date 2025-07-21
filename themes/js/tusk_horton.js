/**
 * 🐘 TuskPHP Horton Theme JavaScript
 * ==================================
 * Job queue management and task monitoring functionality
 */

class TuskHortonTheme {
    constructor() {
        this.jobQueue = [];
        this.workers = [];
        this.statistics = {
            totalJobs: 0,
            completedJobs: 0,
            failedJobs: 0,
            activeWorkers: 0
        };
        this.refreshInterval = null;
        this.init();
    }

    init() {
        this.setupJobMonitoring();
        this.setupWorkerManagement();
        this.setupRealtimeUpdates();
        this.setupProgressTracking();
        this.setupJobControls();
        this.setupDashboardWidgets();
    }

    // Job monitoring setup
    setupJobMonitoring() {
        this.startJobPolling();
        this.createJobStatusUpdaters();
    }

    // Worker management
    setupWorkerManagement() {
        this.initializeWorkers();
        this.setupWorkerStatusUpdates();
    }

    // Real-time updates
    setupRealtimeUpdates() {
        this.refreshInterval = setInterval(() => {
            this.updateJobStatuses();
            this.updateWorkerStatuses();
            this.updateStatistics();
            this.updateProgressBars();
        }, 2000);
    }

    // Progress tracking
    setupProgressTracking() {
        this.enhanceProgressBars();
        this.setupProgressAnimations();
    }

    // Job controls
    setupJobControls() {
        this.setupJobButtons();
        this.setupBulkActions();
        this.setupJobFilters();
    }

    // Dashboard widgets
    setupDashboardWidgets() {
        this.createDashboardCharts();
        this.updateDashboardMetrics();
    }

    // Start job polling
    startJobPolling() {
        // Simulate job creation
        setInterval(() => {
            if (Math.random() < 0.3) { // 30% chance every interval
                this.addRandomJob();
            }
        }, 3000);
    }

    // Add random job
    addRandomJob() {
        const jobTypes = ['email', 'report', 'backup', 'cleanup', 'sync', 'import', 'export'];
        const priorities = ['low', 'normal', 'high', 'urgent'];
        
        const job = {
            id: 'job_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5),
            name: jobTypes[Math.floor(Math.random() * jobTypes.length)] + '_task',
            type: jobTypes[Math.floor(Math.random() * jobTypes.length)],
            priority: priorities[Math.floor(Math.random() * priorities.length)],
            status: 'pending',
            progress: 0,
            startTime: null,
            endTime: null,
            duration: null,
            worker: null,
            retries: 0,
            maxRetries: 3
        };
        
        this.jobQueue.push(job);
        this.statistics.totalJobs++;
        this.addJobToTable(job);
        this.processNextJob();
    }

    // Process next job in queue
    processNextJob() {
        const pendingJob = this.jobQueue.find(job => job.status === 'pending');
        const availableWorker = this.workers.find(worker => worker.status === 'idle');
        
        if (pendingJob && availableWorker) {
            this.startJob(pendingJob, availableWorker);
        }
    }

    // Start job execution
    startJob(job, worker) {
        job.status = 'running';
        job.startTime = Date.now();
        job.worker = worker.id;
        
        worker.status = 'busy';
        worker.currentJob = job.id;
        
        this.updateJobRow(job);
        this.updateWorkerStatus(worker);
        
        // Simulate job execution
        this.simulateJobExecution(job);
    }

    // Simulate job execution
    simulateJobExecution(job) {
        const duration = Math.random() * 15000 + 5000; // 5-20 seconds
        const updateInterval = 200;
        const updates = duration / updateInterval;
        let currentUpdate = 0;
        
        const progressInterval = setInterval(() => {
            currentUpdate++;
            job.progress = Math.min((currentUpdate / updates) * 100, 100);
            
            this.updateJobProgress(job);
            
            if (currentUpdate >= updates) {
                clearInterval(progressInterval);
                this.completeJob(job);
            }
        }, updateInterval);
    }

    // Complete job
    completeJob(job) {
        // 10% chance of failure
        const failed = Math.random() < 0.1;
        
        if (failed && job.retries < job.maxRetries) {
            this.retryJob(job);
        } else {
            job.status = failed ? 'failed' : 'completed';
            job.endTime = Date.now();
            job.duration = job.endTime - job.startTime;
            job.progress = failed ? job.progress : 100;
            
            // Free up worker
            const worker = this.workers.find(w => w.id === job.worker);
            if (worker) {
                worker.status = 'idle';
                worker.currentJob = null;
                this.updateWorkerStatus(worker);
            }
            
            // Update statistics
            if (failed) {
                this.statistics.failedJobs++;
            } else {
                this.statistics.completedJobs++;
            }
            
            this.updateJobRow(job);
            this.processNextJob(); // Start next job
        }
    }

    // Retry job
    retryJob(job) {
        job.retries++;
        job.status = 'retrying';
        job.progress = 0;
        
        this.updateJobRow(job);
        
        // Retry after delay
        setTimeout(() => {
            job.status = 'pending';
            this.updateJobRow(job);
            this.processNextJob();
        }, 2000);
    }

    // Initialize workers
    initializeWorkers() {
        const workerCount = 3;
        for (let i = 1; i <= workerCount; i++) {
            this.workers.push({
                id: `worker_${i}`,
                name: `Worker ${i}`,
                status: 'idle',
                currentJob: null,
                totalJobs: 0,
                successRate: 100
            });
        }
        this.statistics.activeWorkers = workerCount;
    }

    // Update job statuses
    updateJobStatuses() {
        const statusElements = document.querySelectorAll('.status-indicator');
        statusElements.forEach(element => {
            const status = element.className.split(' ').find(cls => cls.startsWith('status-'));
            if (status && Math.random() < 0.05) { // 5% chance to update
                this.animateStatusChange(element);
            }
        });
    }

    // Animate status change
    animateStatusChange(element) {
        element.style.transform = 'scale(1.2)';
        setTimeout(() => {
            element.style.transform = 'scale(1)';
        }, 200);
    }

    // Update worker statuses
    updateWorkerStatuses() {
        this.workers.forEach(worker => {
            // Simulate worker status changes
            if (worker.status === 'busy' && Math.random() < 0.02) {
                // Small chance of worker becoming idle (job completion)
                this.updateWorkerStatus(worker);
            }
        });
    }

    // Update worker status
    updateWorkerStatus(worker) {
        const workerElements = document.querySelectorAll(`[data-worker-id="${worker.id}"]`);
        workerElements.forEach(element => {
            element.className = `status-indicator status-${worker.status}`;
            element.textContent = worker.status.toUpperCase();
        });
    }

    // Update statistics
    updateStatistics() {
        this.updateDashboardMetrics();
    }

    // Update progress bars
    updateProgressBars() {
        const progressBars = document.querySelectorAll('.progress-bar-horton');
        progressBars.forEach(bar => {
            const jobId = bar.dataset.jobId;
            const job = this.jobQueue.find(j => j.id === jobId);
            if (job) {
                bar.style.width = `${job.progress}%`;
            }
        });
    }

    // Add job to table
    addJobToTable(job) {
        const table = document.querySelector('.table-horton tbody');
        if (!table) return;
        
        const row = document.createElement('tr');
        row.dataset.jobId = job.id;
        row.innerHTML = `
            <td class="job-id">${job.id}</td>
            <td class="job-name">${job.name}</td>
            <td class="job-type">${job.type}</td>
            <td>
                <span class="status-indicator status-${job.status}">${job.status.toUpperCase()}</span>
            </td>
            <td>
                <div class="progress-horton">
                    <div class="progress-bar-horton" data-job-id="${job.id}" style="width: ${job.progress}%"></div>
                </div>
            </td>
            <td class="job-duration">-</td>
            <td>
                <button class="btn-horton btn-horton-outline" onclick="window.tuskHortonTheme.pauseJob('${job.id}')">
                    ⏸️
                </button>
                <button class="btn-horton btn-horton-outline" onclick="window.tuskHortonTheme.cancelJob('${job.id}')">
                    ❌
                </button>
            </td>
        `;
        
        table.appendChild(row);
    }

    // Update job row
    updateJobRow(job) {
        const row = document.querySelector(`tr[data-job-id="${job.id}"]`);
        if (!row) return;
        
        const statusElement = row.querySelector('.status-indicator');
        if (statusElement) {
            statusElement.className = `status-indicator status-${job.status}`;
            statusElement.textContent = job.status.toUpperCase();
        }
        
        const progressBar = row.querySelector('.progress-bar-horton');
        if (progressBar) {
            progressBar.style.width = `${job.progress}%`;
        }
        
        const durationElement = row.querySelector('.job-duration');
        if (durationElement && job.duration) {
            durationElement.textContent = this.formatDuration(job.duration);
        }
    }

    // Update job progress
    updateJobProgress(job) {
        const progressBar = document.querySelector(`[data-job-id="${job.id}"]`);
        if (progressBar) {
            progressBar.style.width = `${job.progress}%`;
        }
    }

    // Format duration
    formatDuration(ms) {
        const seconds = Math.floor(ms / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        
        if (hours > 0) {
            return `${hours}h ${minutes % 60}m`;
        } else if (minutes > 0) {
            return `${minutes}m ${seconds % 60}s`;
        } else {
            return `${seconds}s`;
        }
    }

    // Enhance progress bars
    enhanceProgressBars() {
        const progressBars = document.querySelectorAll('.progress-horton');
        progressBars.forEach(progress => {
            progress.addEventListener('click', (e) => {
                const rect = progress.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const percentage = (clickX / rect.width) * 100;
                
                // In real app, this could adjust job priority or restart
                console.log(`Progress clicked at ${percentage.toFixed(1)}%`);
            });
        });
    }

    // Setup progress animations
    setupProgressAnimations() {
        const style = document.createElement('style');
        style.textContent = `
            .progress-bar-horton {
                transition: width 0.3s ease;
            }
            
            .status-indicator {
                transition: all 0.2s ease;
            }
            
            .status-running::before {
                animation: statusPulse 1s infinite;
            }
            
            .status-retrying::before {
                animation: statusSpin 1s linear infinite;
            }
            
            .status-failed::before {
                animation: statusBlink 0.5s infinite;
            }
        `;
        document.head.appendChild(style);
    }

    // Setup job buttons
    setupJobButtons() {
        // Add new job button
        const addJobBtn = document.querySelector('.btn-horton-queue');
        if (addJobBtn) {
            addJobBtn.addEventListener('click', () => {
                this.addRandomJob();
            });
        }
    }

    // Setup bulk actions
    setupBulkActions() {
        // Select all checkboxes
        const selectAllBtn = document.querySelector('[data-action="select-all"]');
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', () => {
                const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = true);
            });
        }
        
        // Bulk pause/resume/cancel
        const bulkActions = document.querySelectorAll('[data-bulk-action]');
        bulkActions.forEach(btn => {
            btn.addEventListener('click', () => {
                const action = btn.dataset.bulkAction;
                const selected = document.querySelectorAll('tbody input[type="checkbox"]:checked');
                selected.forEach(checkbox => {
                    const jobId = checkbox.closest('tr').dataset.jobId;
                    this.performBulkAction(action, jobId);
                });
            });
        });
    }

    // Perform bulk action
    performBulkAction(action, jobId) {
        const job = this.jobQueue.find(j => j.id === jobId);
        if (!job) return;
        
        switch (action) {
            case 'pause':
                this.pauseJob(jobId);
                break;
            case 'resume':
                this.resumeJob(jobId);
                break;
            case 'cancel':
                this.cancelJob(jobId);
                break;
            case 'retry':
                this.retryJob(job);
                break;
        }
    }

    // Job control methods
    pauseJob(jobId) {
        const job = this.jobQueue.find(j => j.id === jobId);
        if (job && job.status === 'running') {
            job.status = 'paused';
            this.updateJobRow(job);
        }
    }

    resumeJob(jobId) {
        const job = this.jobQueue.find(j => j.id === jobId);
        if (job && job.status === 'paused') {
            job.status = 'running';
            this.updateJobRow(job);
        }
    }

    cancelJob(jobId) {
        const job = this.jobQueue.find(j => j.id === jobId);
        if (job) {
            job.status = 'cancelled';
            job.endTime = Date.now();
            this.updateJobRow(job);
            
            // Free up worker
            const worker = this.workers.find(w => w.currentJob === jobId);
            if (worker) {
                worker.status = 'idle';
                worker.currentJob = null;
                this.updateWorkerStatus(worker);
            }
        }
    }

    // Setup job filters
    setupJobFilters() {
        const filterButtons = document.querySelectorAll('[data-filter]');
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.dataset.filter;
                this.filterJobs(filter);
                
                // Update active filter button
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
    }

    // Filter jobs
    filterJobs(status) {
        const rows = document.querySelectorAll('.table-horton tbody tr');
        rows.forEach(row => {
            const jobStatus = row.querySelector('.status-indicator').textContent.toLowerCase();
            if (status === 'all' || jobStatus === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Create dashboard charts
    createDashboardCharts() {
        // Simple chart creation (in real app, use Chart.js or similar)
        const chartContainers = document.querySelectorAll('[data-chart]');
        chartContainers.forEach(container => {
            this.createSimpleChart(container);
        });
    }

    // Create simple chart
    createSimpleChart(container) {
        const canvas = document.createElement('canvas');
        canvas.width = 200;
        canvas.height = 100;
        container.appendChild(canvas);
        
        const ctx = canvas.getContext('2d');
        
        // Store reference for updates
        container._canvas = canvas;
        container._ctx = ctx;
        
        this.updateChart(container);
    }

    // Update chart
    updateChart(container) {
        if (!container._ctx) return;
        
        const ctx = container._ctx;
        const canvas = container._canvas;
        
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Draw simple bar chart
        const data = [
            this.statistics.completedJobs,
            this.statistics.failedJobs,
            this.jobQueue.filter(j => j.status === 'running').length,
            this.jobQueue.filter(j => j.status === 'pending').length
        ];
        
        const colors = ['#16a34a', '#dc2626', '#2563eb', '#64748b'];
        const maxValue = Math.max(...data, 1);
        
        data.forEach((value, index) => {
            const height = (value / maxValue) * 80;
            const x = index * 45 + 10;
            const y = 90 - height;
            
            ctx.fillStyle = colors[index];
            ctx.fillRect(x, y, 35, height);
            
            // Draw value
            ctx.fillStyle = '#000';
            ctx.font = '12px monospace';
            ctx.textAlign = 'center';
            ctx.fillText(value.toString(), x + 17.5, y - 5);
        });
    }

    // Update dashboard metrics
    updateDashboardMetrics() {
        const metrics = {
            '.widget-queue .widget-horton-value': this.jobQueue.filter(j => j.status === 'pending').length,
            '.widget-tasks .widget-horton-value': this.statistics.completedJobs,
            '.widget-workers .widget-horton-value': this.statistics.activeWorkers,
            '.widget-failed .widget-horton-value': this.statistics.failedJobs
        };
        
        Object.entries(metrics).forEach(([selector, value]) => {
            const element = document.querySelector(selector);
            if (element) {
                element.textContent = value;
            }
        });
        
        // Update charts
        const chartContainers = document.querySelectorAll('[data-chart]');
        chartContainers.forEach(container => {
            this.updateChart(container);
        });
    }

    // Cleanup
    destroy() {
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.tuskHortonTheme = new TuskHortonTheme();
    
    // Add control panel
    const controlPanel = document.createElement('div');
    controlPanel.style.position = 'fixed';
    controlPanel.style.top = '80px';
    controlPanel.style.right = '20px';
    controlPanel.style.background = 'var(--bg-secondary)';
    controlPanel.style.border = '1px solid var(--bg-accent)';
    controlPanel.style.borderRadius = 'var(--radius-xl)';
    controlPanel.style.padding = 'var(--space-4)';
    controlPanel.style.zIndex = '1000';
    controlPanel.innerHTML = `
        <h5 style="margin: 0 0 var(--space-3) 0; color: var(--queue-blue);">Queue Control</h5>
        <div style="display: flex; flex-direction: column; gap: var(--space-2);">
            <button class="btn-horton btn-horton-queue" onclick="window.tuskHortonTheme.addRandomJob()" style="font-size: 0.75rem;">
                Add Job
            </button>
            <button class="btn-horton btn-horton-task" onclick="window.tuskHortonTheme.filterJobs('completed')" style="font-size: 0.75rem;">
                Show Completed
            </button>
            <button class="btn-horton btn-horton-worker" onclick="window.tuskHortonTheme.filterJobs('all')" style="font-size: 0.75rem;">
                Show All
            </button>
        </div>
    `;
    document.body.appendChild(controlPanel);
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = TuskHortonTheme;
}