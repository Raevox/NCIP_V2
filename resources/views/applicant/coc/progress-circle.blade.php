@php
    $currentStep = $currentStep ?? 1;
    $totalSteps = 6;
    $stepLabels = [
        1 => 'Step 1',
        2 => 'Step 2', 
        3 => 'Step 3',
        4 => 'Step 4',
        5 => 'Step 5',
        6 => 'Step 6'
    ];
@endphp

<!-- Progress Bar Container -->
<div class="container-fluid px-2 px-md-4 mb-3">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-11 col-md-10 col-lg-8 col-xl-7">
            <div class="progress-container">
                <!-- Step Circles -->
                <div class="steps-container">
                    @for($i = 1; $i <= $totalSteps; $i++)
                        <div class="step-item">
                            <div class="step-circle {{ $i <= $currentStep ? 'active' : '' }}">
                                {{ $i }}
                            </div>
                            <div class="step-label {{ $i <= $currentStep ? 'active' : '' }}">
                                {{ $stepLabels[$i] ?? "Step {$i}" }}
                            </div>
                            
                            @if($i < $totalSteps)
                                <div class="step-line {{ $i < $currentStep ? 'active' : '' }}"></div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Progress Container */
.progress-container {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    margin-top: 2rem; /* 👈 dagdag */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
}

/* Steps Container */
.steps-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
}

.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    flex: 1;
}

/* Step Circles */
.step-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background-color: #e9ecef;
    border: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: #6c757d;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

.step-circle.active {
    border-color: #28a745;
    background-color: #28a745;
    color: white;
}

/* Step Labels */
.step-label {
    margin-top: 0.5rem;
    font-size: 0.8rem;
    color: #6c757d;
    font-weight: 500;
    transition: color 0.3s ease;
    text-align: center;
}

.step-label.active {
    color: #28a745;
    font-weight: 600;
}

/* Step Lines */
.step-line {
    position: absolute;
    top: 17px;
    left: 50%;
    width: 100%;
    height: 2px;
    background-color: #e9ecef;
    z-index: 1;
    transition: background-color 0.3s ease;
}

.step-line.active {
    background-color: #28a745;
}

/* Responsive Design */
@media (max-width: 768px) {
    .progress-container {
        padding: 0.75rem;
    }
    
    .step-circle {
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }
    
    .step-label {
        font-size: 0.7rem;
        margin-top: 0.4rem;
    }
    
    .step-line {
        top: 15px;
    }
}

@media (max-width: 480px) {
    .step-circle {
        width: 28px;
        height: 28px;
        font-size: 0.75rem;
    }
    
    .step-label {
        font-size: 0.65rem;
        margin-top: 0.3rem;
    }
    
    .step-line {
        top: 14px;
    }
}
</style>
