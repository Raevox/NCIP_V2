@php
$finalLabel = in_array($application->status, ['Approved', 'Returned']) 
                ? $application->status 
                : 'Approved';

$steps = [
    ['label' => 'Submitted', 'status' => 'Submitted'],
    ['label' => 'Under Review', 'status' => 'Under Review'],
    ['label' => $finalLabel, 'status' => $application->status ?? 'Pending'],
];

$currentStatus = $application->status ?? 'Submitted';

$statusColors = [
    'Submitted' => '#16a34a',    
    'Under Review' => '#f59e0b', 
    'Approved' => '#16a34a',     
    'Returned' => '#dc2626',     
    'Pending' => '#f59e0b',      
];

$currentStep = 1;
if($currentStatus === 'Under Review') $currentStep = 2;
if(in_array($currentStatus, ['Approved','Returned'])) $currentStep = 3;
@endphp

<div class="progress-steps-container">
    <div class="progress-steps">
        @foreach($steps as $index => $step)
            @php
                $stepIndex = $index + 1;
                $isActive = $stepIndex <= $currentStep;
                $isCurrent = $stepIndex === $currentStep;
                $circleColor = $isActive ? ($statusColors[$step['status']] ?? '#16a34a') : '#d1d5db';

                // Determine circle content
                if($stepIndex < $currentStep) {
                    $circleContent = '✔';
                } elseif($stepIndex === 3) {
                    $circleContent = $currentStatus === 'Returned' ? '✖' : '✔';
                } else {
                    $circleContent = $stepIndex;
                }
            @endphp

            <div class="step">
                <div class="step-circle {{ $isCurrent ? 'pulse' : '' }}" style="background: {{ $circleColor }};">
                    {{ $circleContent }}
                </div>

                @if($index != count($steps)-1)
                    <div class="step-line">
                        <div class="fill-line {{ $stepIndex < $currentStep ? 'active' : '' }}" 
                             style="background: {{ $statusColors[$step['status']] ?? '#16a34a' }};"></div>
                    </div>
                @endif
                <p>{{ $step['label'] }}</p>
            </div>
        @endforeach
    </div>
</div>


<style>
.progress-steps-container {
    padding: 1rem;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 20px;
    overflow-x: auto;
    margin-top: 15px !important;
}

.progress-steps {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: nowrap;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
    position: relative;
}

.step-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2;
    font-weight: bold;
    font-size: 18px;
    color: #fff;
    transition: all 0.5s ease;
}
.pulse {
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(0,0,0,0.3); }
    50% { box-shadow: 0 0 20px 8px rgba(0,0,0,0.2); }
    100% { box-shadow: 0 0 0 0 rgba(0,0,0,0.3); }
}

.step-line {
    flex: 1;
    height: 4px;
    background: #e5e7eb;
    margin: 0 -2px;
    position: relative;
    overflow: hidden;
    border-radius: 2px;
}

.fill-line {
    height: 100%;
    width: 0%;
    transition: width 1s ease;
    border-radius: 2px;
}
@media (max-width: 500px) {
    .progress-steps {
        flex-direction: column;
        align-items: flex-start;
    }
    .step {
        flex-direction: row;
        align-items: center;
        margin-bottom: 16px;
    }
    .step p {
        margin-left: 12px;
        margin-top: 0;
    }
    .step-line {
        width: 40px;
        height: 4px;
        margin: 0 8px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fillLines = document.querySelectorAll('.fill-line');

    fillLines.forEach((line, index) => {
        setTimeout(() => {
            line.style.width = '100%';
        }, index * 400); 
    });
});
</script>
