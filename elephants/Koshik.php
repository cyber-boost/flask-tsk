<?php
/**
 * <?tusk> TuskPHP Koshik - The Speaking Notification System
 * =========================================================
 * 
 * 🐘 BACKSTORY: Koshik - The Elephant Who Learned to Speak
 * -------------------------------------------------------
 * Koshik, an Asian elephant at the Everland Zoo in South Korea, amazed the
 * world by learning to "speak" Korean words. By placing his trunk in his mouth
 * and modulating his vocal tract, Koshik could mimic human speech, saying
 * words like "annyong" (hello), "anja" (sit down), "aniya" (no), "nuo" (lie
 * down), and "choah" (good). Scientists believe he learned to vocalize to bond
 * with his human keepers, as he was the only elephant at the zoo for years.
 * 
 * WHY THIS NAME: Like Koshik who bridged the communication gap between elephants
 * and humans, this notification system creates audio alerts and spoken messages
 * for your users. Whether it's a simple "ding" or complex voice notifications,
 * Koshik helps your application speak to users in ways they'll understand and
 * remember.
 * 
 * "Annyong!" - Koshik's greeting to the world
 * 
 * FEATURES:
 * - Client-side audio generation
 * - Text-to-speech capabilities
 * - Custom notification sounds
 * - Multi-language support
 * - Audio sprite management
 * - Volume control and muting
 * - Notification queuing
 * 
 * @package TuskPHP\Elephants
 * @author  TuskPHP Team
 * @since   1.0.0
 */

namespace TuskPHP\Elephants;

use TuskPHP\{Memory};

class Koshik {
    
    private $vocabulary = [];      // Koshik's learned words
    private $audioContext = null;  // Web Audio API context
    private $volume = 0.7;         // How loud Koshik speaks
    private $language = 'en';      // Current language
    private $voiceProfiles = [];   // Voice configurations per language
    private $synthesisParams = []; // Audio synthesis parameters
    private $audioQueue = [];      // Queue for sequential audio playback
    private $soundBank = [];       // Pre-generated sound library
    
    /**
     * Initialize Koshik - The elephant prepares to speak
     */
    public function __construct() {
        $this->learnBasicVocabulary();
        $this->prepareAudioSystem();
    }
    
    /**
     * Speak a message - Koshik vocalizes
     */
    public function speak($message, $options = []) {
        $voice = $options['voice'] ?? 'koshik';
        $language = $options['language'] ?? $this->language;
        $emotion = $options['emotion'] ?? 'friendly';
        
        // Generate speech configuration
        $speechConfig = [
            'text' => $message,
            'voice' => $this->selectVoice($voice, $language),
            'rate' => $options['rate'] ?? 1.0,
            'pitch' => $options['pitch'] ?? 1.0,
            'volume' => $options['volume'] ?? $this->volume
        ];
        
        // Create the vocalization
        $audio = $this->generateSpeech($speechConfig);
        
        // Remember what Koshik said
        $this->rememberUtterance($message, $language);
        
        return $audio;
    }
    
    /**
     * Create notification sound - Koshik's alert trumpet
     */
    public function notify($type = 'default', $options = []) {
        // Koshik's different notification sounds
        $sounds = [
            'default' => $this->createTrumpet(440, 0.2),     // A4 note
            'success' => $this->createHappySound(),          // Rising tone
            'warning' => $this->createWarningSound(),        // Two quick notes
            'error' => $this->createErrorSound(),            // Descending tone
            'message' => $this->createMessageSound(),        // Gentle chime
            'annyong' => $this->createAnnyongSound()        // Koshik's hello!
        ];
        
        $soundData = $sounds[$type] ?? $sounds['default'];
        
        // Apply options
        if (isset($options['volume'])) {
            $soundData['volume'] = $options['volume'];
        }
        
        return $this->generateAudioScript($soundData);
    }
    
    /**
     * Generate client-side audio - Koshik's voice box
     */
    private function generateAudioScript($config) {
        $script = <<<JS
<script>
(function() {
    // Koshik's Audio Generator
    const KoshikSpeak = {
        context: null,
        
        init: function() {
            if (!this.context) {
                this.context = new (window.AudioContext || window.webkitAudioContext)();
            }
        },
        
        playSound: function(frequency, duration, type = 'sine') {
            this.init();
            
            const oscillator = this.context.createOscillator();
            const gainNode = this.context.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(this.context.destination);
            
            oscillator.frequency.value = frequency;
            oscillator.type = type;
            
            gainNode.gain.setValueAtTime({$config['volume']}, this.context.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, this.context.currentTime + duration);
            
            oscillator.start(this.context.currentTime);
            oscillator.stop(this.context.currentTime + duration);
        },
        
        trumpet: function() {
            // Koshik's signature elephant trumpet
            this.playSound({$config['frequency']}, {$config['duration']});
        }
    };
    
    // Play the sound
    KoshikSpeak.trumpet();
    
    // Koshik says: "{$config['message']}"
})();
</script>
JS;
        
        return $script;
    }
    
    /**
     * Create happy sound - When Koshik says "choah" (good)
     */
    private function createHappySound() {
        return [
            'type' => 'sequence',
            'notes' => [
                ['frequency' => 523.25, 'duration' => 0.1], // C5
                ['frequency' => 659.25, 'duration' => 0.1], // E5
                ['frequency' => 783.99, 'duration' => 0.2], // G5
            ],
            'volume' => $this->volume,
            'message' => 'choah!'
        ];
    }
    
    /**
     * Create warning sound - When Koshik says "aniya" (no)
     */
    private function createWarningSound() {
        return [
            'type' => 'sequence',
            'notes' => [
                ['frequency' => 440, 'duration' => 0.15],  // A4
                ['frequency' => 440, 'duration' => 0.15],  // A4
            ],
            'volume' => $this->volume,
            'message' => 'aniya!'
        ];
    }
    
    /**
     * Learn basic vocabulary - Koshik's Korean lessons
     */
    private function learnBasicVocabulary() {
        $this->vocabulary = [
            'ko' => [
                // Original Koshik words
                'hello' => 'annyong',
                'sit' => 'anja',
                'no' => 'aniya',
                'lie_down' => 'nuo',
                'good' => 'choah',
                
                // Extended Korean vocabulary
                'goodbye' => 'annyeonghi gaseyo',
                'thank_you' => 'gamsahamnida',
                'yes' => 'ne',
                'please' => 'jebal',
                'sorry' => 'mianhae',
                'love' => 'saranghae',
                'friend' => 'chingu',
                'elephant' => 'kokkiri',
                'water' => 'mul',
                'food' => 'eumsik',
                'play' => 'nolda',
                'sleep' => 'jada',
                'happy' => 'haengbokhae',
                'beautiful' => 'areumdawo',
                'strong' => 'himdeulda',
                'smart' => 'ttokttokhada',
                'come' => 'wa',
                'go' => 'ga',
                'eat' => 'meokda',
                'drink' => 'masida',
                'walk' => 'geotda',
                'run' => 'dallyeoda',
                'stop' => 'meomchwo',
                'help' => 'dowajuseyo',
                'understand' => 'algetseumnida',
                'morning' => 'achim',
                'night' => 'bam',
                'today' => 'oneul',
                'tomorrow' => 'naeil',
                'family' => 'gajok',
                'mother' => 'eomma',
                'father' => 'appa',
                'baby' => 'agi',
                'big' => 'keun',
                'small' => 'jageun',
                'hot' => 'deoweyo',
                'cold' => 'chuweyo',
                'hungry' => 'baegopa',
                'tired' => 'pigonhae',
                'excited' => 'heungbunhae',
                'dance' => 'chumchuda',
                'sing' => 'noraehada',
                'laugh' => 'utda',
                'cry' => 'ulda',
                'work' => 'ilhada',
                'rest' => 'swida',
                'learn' => 'baeuda',
                'teach' => 'gareuchida',
                'remember' => 'gieokhada',
                'forget' => 'ijda',
                'dream' => 'kkum',
                'hope' => 'huimang',
                'courage' => 'yonggi',
                'peace' => 'pyeonghwa',
                'together' => 'hamkke',
                'alone' => 'honja',
                'always' => 'hangsang',
                'never' => 'jeoldae',
                'maybe' => 'amado',
                'certainly' => 'hwaksilhi',
                'welcome' => 'hwanyeong',
                'congratulations' => 'chukhahaeyo'
            ],
            'en' => [
                'hello' => 'hello',
                'goodbye' => 'goodbye',
                'yes' => 'yes',
                'no' => 'no',
                'good' => 'good',
                'thank_you' => 'thank you',
                'please' => 'please',
                'sorry' => 'sorry',
                'love' => 'love',
                'friend' => 'friend',
                'elephant' => 'elephant',
                'happy' => 'happy',
                'play' => 'play',
                'help' => 'help',
                'welcome' => 'welcome',
                'amazing' => 'amazing',
                'wonderful' => 'wonderful',
                'excellent' => 'excellent',
                'perfect' => 'perfect',
                'beautiful' => 'beautiful'
            ],
            'es' => [
                'hello' => 'hola',
                'goodbye' => 'adiós',
                'yes' => 'sí',
                'no' => 'no',
                'good' => 'bueno',
                'thank_you' => 'gracias',
                'please' => 'por favor',
                'sorry' => 'lo siento',
                'love' => 'amor',
                'friend' => 'amigo',
                'elephant' => 'elefante',
                'happy' => 'feliz',
                'beautiful' => 'hermoso'
            ],
            'fr' => [
                'hello' => 'bonjour',
                'goodbye' => 'au revoir',
                'yes' => 'oui',
                'no' => 'non',
                'good' => 'bon',
                'thank_you' => 'merci',
                'please' => 's\'il vous plaît',
                'sorry' => 'désolé',
                'love' => 'amour',
                'friend' => 'ami',
                'elephant' => 'éléphant',
                'happy' => 'heureux',
                'beautiful' => 'beau'
            ],
            'de' => [
                'hello' => 'hallo',
                'goodbye' => 'auf wiedersehen',
                'yes' => 'ja',
                'no' => 'nein',
                'good' => 'gut',
                'thank_you' => 'danke',
                'please' => 'bitte',
                'sorry' => 'entschuldigung',
                'love' => 'liebe',
                'friend' => 'freund',
                'elephant' => 'elefant',
                'happy' => 'glücklich',
                'beautiful' => 'schön'
            ],
            'ja' => [
                'hello' => 'konnichiwa',
                'goodbye' => 'sayonara',
                'yes' => 'hai',
                'no' => 'iie',
                'good' => 'yoi',
                'thank_you' => 'arigatou',
                'please' => 'onegaishimasu',
                'sorry' => 'gomenasai',
                'love' => 'ai',
                'friend' => 'tomodachi',
                'elephant' => 'zou',
                'happy' => 'shiawase',
                'beautiful' => 'utsukushii'
            ],
            'zh' => [
                'hello' => 'nǐ hǎo',
                'goodbye' => 'zàijiàn',
                'yes' => 'shì',
                'no' => 'bù',
                'good' => 'hǎo',
                'thank_you' => 'xièxiè',
                'please' => 'qǐng',
                'sorry' => 'duìbùqǐ',
                'love' => 'ài',
                'friend' => 'péngyǒu',
                'elephant' => 'dàxiàng',
                'happy' => 'kuàilè',
                'beautiful' => 'měilì'
            ]
        ];
        
        // Cache the vocabulary
        Memory::remember('koshik_vocabulary', $this->vocabulary, 86400);
    }
    
    /**
     * Text to speech - Koshik attempts human language
     */
    public function say($word, $language = 'en') {
        // Check if Koshik knows this word
        if (isset($this->vocabulary[$language][$word])) {
            $pronunciation = $this->vocabulary[$language][$word];
            
            // Generate speech synthesis script
            return $this->generateTTSScript($pronunciation, $language);
        }
        
        // Koshik doesn't know this word yet
        return $this->notify('default', ['message' => 'Koshik is still learning!']);
    }
    
    /**
     * Generate TTS script - Modern speech synthesis
     */
    private function generateTTSScript($text, $language, $options = []) {
        $rate = $options['rate'] ?? 0.9;
        $pitch = $options['pitch'] ?? 1.1;
        $volume = $options['volume'] ?? $this->volume;
        
        $script = <<<JS
<script>
(function() {
    // Koshik's Text-to-Speech
    const utterance = new SpeechSynthesisUtterance('{$text}');
    utterance.lang = '{$language}';
    utterance.rate = {$rate};
    utterance.pitch = {$pitch};
    utterance.volume = {$volume};
    
    // Koshik speaks!
    window.speechSynthesis.speak(utterance);
    
    console.log('🐘 Koshik says: "{$text}"');
})();
</script>
JS;
        
        return $script;
    }
    
    /**
     * Generate melody script for browser playback
     */
    private function generateMelodyScript($sequence) {
        $notesJson = json_encode($sequence['notes']);
        $tempo = $sequence['tempo'];
        $effects = json_encode($sequence['effects'] ?? []);
        
        $script = <<<JS
<script>
(function() {
    // Koshik's Melody Player
    const KoshikMelody = {
        context: new (window.AudioContext || window.webkitAudioContext)(),
        tempo: {$tempo},
        notes: {$notesJson},
        effects: {$effects},
        
        playMelody: function() {
            let time = this.context.currentTime;
            const beatDuration = 60 / this.tempo;
            
            this.notes.forEach((note, index) => {
                const oscillator = this.context.createOscillator();
                const gainNode = this.context.createGain();
                
                oscillator.connect(gainNode);
                
                // Apply effects if any
                let lastNode = gainNode;
                if (this.effects.reverb) {
                    // Simple reverb simulation
                    const convolver = this.context.createConvolver();
                    lastNode.connect(convolver);
                    lastNode = convolver;
                }
                
                lastNode.connect(this.context.destination);
                
                oscillator.frequency.value = note.frequency;
                oscillator.type = '{$sequence['instrument']}';
                
                // Set envelope
                gainNode.gain.setValueAtTime(0, time);
                gainNode.gain.linearRampToValueAtTime(note.velocity * {$this->volume}, time + 0.01);
                gainNode.gain.exponentialRampToValueAtTime(0.01, time + note.duration * beatDuration);
                
                oscillator.start(time);
                oscillator.stop(time + note.duration * beatDuration);
                
                time += note.duration * beatDuration;
            });
            
            console.log('🐘 Koshik plays a melody!');
        }
    };
    
    // Play the melody
    KoshikMelody.playMelody();
})();
</script>
JS;
        
        return $script;
    }
    
    /**
     * Prepare audio system - Initialize Koshik's voice capabilities
     */
    private function prepareAudioSystem() {
        // Initialize audio configuration
        $this->audioContext = [
            'sampleRate' => 44100,
            'channels' => 2,
            'bitDepth' => 16,
            'format' => 'webm',
            'codec' => 'opus'
        ];
        
        // Load voice profiles for different languages
        $this->loadVoiceProfiles();
        
        // Initialize sound synthesis parameters
        $this->initializeSynthesisParams();
        
        // Cache audio system state
        Memory::remember('koshik_audio_system', $this->audioContext, 3600);
    }
    
    /**
     * Load voice profiles for multiple languages
     */
    private function loadVoiceProfiles() {
        $this->voiceProfiles = [
            'en' => [
                'male' => ['pitch' => 1.0, 'rate' => 1.0, 'voice' => 'en-US-Standard-B'],
                'female' => ['pitch' => 1.2, 'rate' => 1.0, 'voice' => 'en-US-Standard-C'],
                'koshik' => ['pitch' => 0.9, 'rate' => 0.85, 'voice' => 'en-US-Wavenet-D']
            ],
            'ko' => [
                'male' => ['pitch' => 1.0, 'rate' => 0.9, 'voice' => 'ko-KR-Standard-A'],
                'female' => ['pitch' => 1.15, 'rate' => 0.95, 'voice' => 'ko-KR-Standard-B'],
                'koshik' => ['pitch' => 0.85, 'rate' => 0.8, 'voice' => 'ko-KR-Wavenet-A'] // Deeper, slower for elephant
            ],
            'es' => [
                'male' => ['pitch' => 1.0, 'rate' => 1.0, 'voice' => 'es-ES-Standard-A'],
                'female' => ['pitch' => 1.2, 'rate' => 1.0, 'voice' => 'es-ES-Standard-C'],
                'koshik' => ['pitch' => 0.9, 'rate' => 0.9, 'voice' => 'es-ES-Wavenet-B']
            ]
        ];
    }
    
    /**
     * Initialize synthesis parameters
     */
    private function initializeSynthesisParams() {
        $this->synthesisParams = [
            'waveforms' => ['sine', 'square', 'sawtooth', 'triangle'],
            'effects' => [
                'reverb' => ['roomSize' => 0.7, 'dampening' => 0.5],
                'delay' => ['time' => 0.3, 'feedback' => 0.4],
                'distortion' => ['amount' => 0.2, 'oversample' => '4x']
            ],
            'envelopes' => [
                'default' => ['attack' => 0.01, 'decay' => 0.1, 'sustain' => 0.7, 'release' => 0.2],
                'pluck' => ['attack' => 0.002, 'decay' => 0.998, 'sustain' => 0, 'release' => 0],
                'pad' => ['attack' => 0.5, 'decay' => 0.3, 'sustain' => 0.8, 'release' => 1.0]
            ]
        ];
    }
    
    /**
     * Select appropriate voice for the message
     */
    private function selectVoice($voice, $language) {
        // Default to English if language not supported
        if (!isset($this->voiceProfiles[$language])) {
            $language = 'en';
        }
        
        // Get voice profile
        if (isset($this->voiceProfiles[$language][$voice])) {
            return $this->voiceProfiles[$language][$voice];
        }
        
        // Default to Koshik's special voice
        return $this->voiceProfiles[$language]['koshik'];
    }
    
    /**
     * Generate speech configuration for TTS
     */
    private function generateSpeech($config) {
        $speechData = [
            'id' => 'koshik_speech_' . uniqid(),
            'text' => $config['text'],
            'voice' => $config['voice'],
            'audioConfig' => [
                'audioEncoding' => $this->audioContext['codec'],
                'speakingRate' => $config['rate'],
                'pitch' => $config['pitch'],
                'volumeGainDb' => $this->convertVolumeToDb($config['volume']),
                'sampleRateHertz' => $this->audioContext['sampleRate']
            ],
            'timestamp' => time()
        ];
        
        // Apply voice effects if specified
        if (isset($config['effects'])) {
            $speechData['effects'] = $this->applyVoiceEffects($config['effects']);
        }
        
        // Cache the speech configuration
        Memory::remember("koshik_speech_{$speechData['id']}", $speechData, 300);
        
        return $speechData;
    }
    
    /**
     * Convert volume (0-1) to decibels
     */
    private function convertVolumeToDb($volume) {
        // Convert linear volume to dB (-96dB to 0dB range)
        if ($volume <= 0) return -96;
        return 20 * log10($volume);
    }
    
    /**
     * Apply voice effects to speech
     */
    private function applyVoiceEffects($effects) {
        $processedEffects = [];
        
        foreach ($effects as $effect => $params) {
            if (isset($this->synthesisParams['effects'][$effect])) {
                $processedEffects[$effect] = array_merge(
                    $this->synthesisParams['effects'][$effect],
                    $params
                );
            }
        }
        
        return $processedEffects;
    }
    
    /**
     * Create trumpet sound - Koshik's signature
     */
    private function createTrumpet($frequency, $duration) {
        return [
            'type' => 'complex',
            'frequency' => $frequency,
            'duration' => $duration,
            'harmonics' => [
                1.0,   // Fundamental
                0.8,   // 2nd harmonic
                0.6,   // 3rd harmonic
                0.4,   // 4th harmonic
                0.2    // 5th harmonic
            ],
            'envelope' => $this->synthesisParams['envelopes']['default'],
            'vibrato' => [
                'frequency' => 5,
                'depth' => 0.02
            ],
            'volume' => $this->volume,
            'message' => 'Koshik trumpets!'
        ];
    }
    
    /**
     * Create error sound - Descending tone
     */
    private function createErrorSound() {
        return [
            'type' => 'sequence',
            'notes' => [
                ['frequency' => 587.33, 'duration' => 0.2], // D5
                ['frequency' => 493.88, 'duration' => 0.2], // B4
                ['frequency' => 392.00, 'duration' => 0.3], // G4
            ],
            'waveform' => 'sawtooth',
            'envelope' => $this->synthesisParams['envelopes']['pluck'],
            'volume' => $this->volume * 0.8,
            'message' => 'aniya!' // No!
        ];
    }
    
    /**
     * Create message sound - Gentle chime
     */
    private function createMessageSound() {
        return [
            'type' => 'chord',
            'frequencies' => [523.25, 659.25, 783.99, 1046.50], // C5 E5 G5 C6
            'duration' => 0.6,
            'waveform' => 'sine',
            'envelope' => $this->synthesisParams['envelopes']['pad'],
            'effects' => ['reverb' => ['roomSize' => 0.8]],
            'volume' => $this->volume * 0.6,
            'message' => 'saranghae' // Love (in Korean)
        ];
    }
    
    /**
     * Create Annyong sound - Koshik's greeting
     */
    private function createAnnyongSound() {
        return [
            'type' => 'modulated',
            'baseFrequency' => 440,
            'modulation' => [
                'type' => 'frequency',
                'depth' => 50,
                'rate' => 8,
                'shape' => 'sine'
            ],
            'duration' => 0.5,
            'harmonics' => [1.0, 0.5, 0.3],
            'volume' => $this->volume,
            'message' => 'annyong!' // Hello!
        ];
    }
    
    /**
     * Create audio sprite - Koshik's sound collection
     */
    public function createAudioSprite($sounds) {
        $sprite = [
            'id' => 'koshik_sprite_' . uniqid(),
            'sounds' => [],
            'duration' => 0,
            'metadata' => [
                'created' => time(),
                'format' => $this->audioContext['format'],
                'sampleRate' => $this->audioContext['sampleRate']
            ]
        ];
        
        foreach ($sounds as $name => $config) {
            $sprite['sounds'][$name] = [
                'start' => $sprite['duration'],
                'duration' => $config['duration'] ?? 0.5,
                'config' => $config,
                'peaks' => $this->generateWaveformPeaks($config) // For visualization
            ];
            
            $sprite['duration'] += $config['duration'] ?? 0.5;
        }
        
        Memory::remember("koshik_sprite_{$sprite['id']}", $sprite, 3600);
        
        return $sprite;
    }
    
    /**
     * Generate waveform peaks for visualization
     */
    private function generateWaveformPeaks($config) {
        $duration = $config['duration'] ?? 0.5;
        $sampleRate = 50; // 50 samples per second for visualization
        $numSamples = (int)($duration * $sampleRate);
        $peaks = [];
        
        for ($i = 0; $i < $numSamples; $i++) {
            // Generate realistic waveform peaks based on sound type
            $time = $i / $sampleRate;
            $envelope = $this->calculateEnvelope($time, $duration, $config['envelope'] ?? null);
            $amplitude = $envelope * ($config['volume'] ?? $this->volume);
            
            // Add some variation for realism
            $peaks[] = $amplitude * (0.8 + 0.2 * sin($i * 0.5));
        }
        
        return $peaks;
    }
    
    /**
     * Calculate envelope value at given time
     */
    private function calculateEnvelope($time, $duration, $envelope = null) {
        if (!$envelope) {
            $envelope = $this->synthesisParams['envelopes']['default'];
        }
        
        $attack = $envelope['attack'] * $duration;
        $decay = $envelope['decay'] * $duration;
        $sustain = $envelope['sustain'];
        $release = $envelope['release'] * $duration;
        
        if ($time < $attack) {
            // Attack phase
            return $time / $attack;
        } elseif ($time < $attack + $decay) {
            // Decay phase
            $decayTime = $time - $attack;
            return 1.0 - (1.0 - $sustain) * ($decayTime / $decay);
        } elseif ($time < $duration - $release) {
            // Sustain phase
            return $sustain;
        } else {
            // Release phase
            $releaseTime = $time - ($duration - $release);
            return $sustain * (1.0 - $releaseTime / $release);
        }
    }
    
    /**
     * Get Koshik's stats - What has he learned?
     */
    public function getVocabularyStats() {
        return [
            'languages_known' => array_keys($this->vocabulary),
            'total_words' => array_sum(array_map('count', $this->vocabulary)),
            'korean_words' => count($this->vocabulary['ko'] ?? []),
            'most_said' => Memory::recall('koshik_most_said') ?? 'annyong',
            'utterance_count' => Memory::recall('koshik_utterance_count') ?? 0
        ];
    }
    
    /**
     * Remember what was said - Koshik never forgets
     */
    private function rememberUtterance($message, $language) {
        $count = Memory::recall('koshik_utterance_count') ?? 0;
        Memory::remember('koshik_utterance_count', $count + 1, 86400);
        
        Memory::remember("koshik_last_said", [
            'message' => $message,
            'language' => $language,
            'time' => time()
        ], 3600);
    }
    
    /**
     * Static Methods for Integration with TuskPHP Core
     * ==============================================
     */
    
    /**
     * Check if Koshik audio notifications are enabled
     */
    public static function isEnabled() {
        // Check if audio notifications are enabled in user preferences
        $globalSetting = Memory::recall('koshik_global_enabled') ?? true;
        
        // Check if user has audio enabled (from session/preferences)
        $userSetting = $_SESSION['koshik_enabled'] ?? true;
        
        return $globalSetting && $userSetting;
    }
    
    /**
     * Determine if audio should play for this action and user role
     */
    public static function shouldPlaySound($action, $userRole) {
        // Don't play sounds for public pages
        if ($action === 'public' || $action === 'home') {
            return false;
        }
        
        // Audio settings by role and action
        $soundSettings = [
            'admin' => [
                'login' => true,
                'users' => true,
                'system' => true,
                'logs' => false,  // Too frequent
            ],
            'manager' => [
                'login' => true,
                'reports' => true,
                'team' => true,
            ],
            'editor' => [
                'login' => true,
                'content' => false,  // Writing mode should be quiet
            ],
            'protected' => [
                'login' => true,
                'dashboard' => true,
                'profile' => false,
                'settings' => false,
            ]
        ];
        
        // Check role-specific settings
        if (isset($soundSettings[$userRole][$action])) {
            return $soundSettings[$userRole][$action];
        }
        
        // Default behavior for new actions
        return in_array($action, ['login', 'dashboard']);
    }
    
    /**
     * Queue a notification for the user
     */
    public static function queueNotification($userId, $action, $options = []) {
        // Create notification data
        $notification = [
            'id' => uniqid('koshik_'),
            'user_id' => $userId,
            'action' => $action,
            'sound_type' => self::determineSoundType($action),
            'message' => self::generateMessage($action),
            'created_at' => time(),
            'played' => false,
            'options' => $options
        ];
        
        // Get current user's notification queue
        $queueKey = "koshik_queue_{$userId}";
        $queue = Memory::recall($queueKey) ?? [];
        
        // Add new notification
        $queue[] = $notification;
        
        // Keep only last 5 notifications
        $queue = array_slice($queue, -5);
        
        // Store updated queue (expire in 1 hour)
        Memory::remember($queueKey, $queue, 3600);
        
        return $notification['id'];
    }
    
    /**
     * Get pending notifications for user
     */
    public static function getPendingNotifications($userId) {
        $queueKey = "koshik_queue_{$userId}";
        $queue = Memory::recall($queueKey) ?? [];
        
        // Return only unplayed notifications
        return array_filter($queue, function($notification) {
            return !$notification['played'];
        });
    }
    
    /**
     * Mark notification as played
     */
    public static function markAsPlayed($userId, $notificationId) {
        $queueKey = "koshik_queue_{$userId}";
        $queue = Memory::recall($queueKey) ?? [];
        
        // Find and mark as played
        foreach ($queue as &$notification) {
            if ($notification['id'] === $notificationId) {
                $notification['played'] = true;
                break;
            }
        }
        
        // Update queue
        Memory::remember($queueKey, $queue, 3600);
    }
    
    /**
     * Clear all notifications for user
     */
    public static function clearNotifications($userId) {
        $queueKey = "koshik_queue_{$userId}";
        Memory::forget($queueKey);
    }
    
    /**
     * Determine sound type based on action
     */
    private static function determineSoundType($action) {
        $soundMap = [
            'login' => 'welcome',
            'dashboard' => 'soft_chime',
            'admin' => 'authority',
            'manager' => 'success',
            'editor' => 'creative',
            'users' => 'notification',
            'system' => 'alert',
            'reports' => 'completion',
            'team' => 'group',
            'content' => 'writing',
            'profile' => 'personal',
            'settings' => 'config',
            'error' => 'warning',
            'success' => 'celebration'
        ];
        
        return $soundMap[$action] ?? 'default';
    }
    
    /**
     * Generate Koshik's message for the action
     */
    private static function generateMessage($action) {
        $messages = [
            'login' => 'annyong!',  // Koshik's hello
            'dashboard' => 'choah!',  // Good!
            'admin' => 'anja!',  // Attention!
            'manager' => 'nuo',  // Ready
            'editor' => 'choah',  // Good for writing
            'error' => 'aniya!',  // No! (something wrong)
            'success' => 'choah!',  // Good!
        ];
        
        return $messages[$action] ?? 'annyong';
    }
    
    /**
     * Get user's audio preferences
     */
    public static function getUserPreferences($userId) {
        $prefsKey = "koshik_prefs_{$userId}";
        $defaults = [
            'enabled' => true,
            'volume' => 0.7,
            'sounds' => [
                'login' => true,
                'navigation' => true,
                'notifications' => true,
                'errors' => true,
                'success' => true
            ],
            'language' => 'en'
        ];
        
        return Memory::recall($prefsKey) ?? $defaults;
    }
    
    /**
     * Update user's audio preferences
     */
    public static function updateUserPreferences($userId, $preferences) {
        $prefsKey = "koshik_prefs_{$userId}";
        $current = self::getUserPreferences($userId);
        $updated = array_merge($current, $preferences);
        
        Memory::remember($prefsKey, $updated, 86400 * 30); // 30 days
        
        return $updated;
    }
    
    /**
     * Advanced Audio Features
     * ======================
     */
    
    /**
     * Generate musical sequence - Koshik plays a melody
     */
    public function playMelody($melody, $options = []) {
        $tempo = $options['tempo'] ?? 120; // BPM
        $key = $options['key'] ?? 'C'; // Musical key
        $scale = $options['scale'] ?? 'major'; // major/minor/pentatonic
        
        // Convert note names to frequencies
        $notes = $this->convertMelodyToFrequencies($melody, $key, $scale);
        
        // Create sequence configuration
        $sequence = [
            'type' => 'melody',
            'notes' => $notes,
            'tempo' => $tempo,
            'instrument' => $options['instrument'] ?? 'sine',
            'effects' => $options['effects'] ?? ['reverb' => ['roomSize' => 0.6]]
        ];
        
        return $this->generateMelodyScript($sequence);
    }
    
    /**
     * Convert melody notation to frequencies
     */
    private function convertMelodyToFrequencies($melody, $key, $scale) {
        // Musical note frequencies (A4 = 440Hz)
        $noteFrequencies = [
            'C' => 261.63, 'C#' => 277.18, 'D' => 293.66, 'D#' => 311.13,
            'E' => 329.63, 'F' => 349.23, 'F#' => 369.99, 'G' => 392.00,
            'G#' => 415.30, 'A' => 440.00, 'A#' => 466.16, 'B' => 493.88
        ];
        
        // Scale patterns (semitones from root)
        $scalePatterns = [
            'major' => [0, 2, 4, 5, 7, 9, 11],
            'minor' => [0, 2, 3, 5, 7, 8, 10],
            'pentatonic' => [0, 2, 4, 7, 9],
            'blues' => [0, 3, 5, 6, 7, 10],
            'dorian' => [0, 2, 3, 5, 7, 9, 10],
            'phrygian' => [0, 1, 3, 5, 7, 8, 10]
        ];
        
        $frequencies = [];
        $pattern = $scalePatterns[$scale] ?? $scalePatterns['major'];
        
        foreach ($melody as $note) {
            if (is_array($note)) {
                // Note with duration and octave
                $pitch = $note['pitch'] ?? 'C4';
                $duration = $note['duration'] ?? 0.25;
                $octave = (int)substr($pitch, -1, 1) ?? 4;
                $noteName = substr($pitch, 0, -1);
                
                $baseFreq = $noteFrequencies[$noteName] ?? 440;
                $frequency = $baseFreq * pow(2, $octave - 4);
                
                $frequencies[] = [
                    'frequency' => $frequency,
                    'duration' => $duration,
                    'velocity' => $note['velocity'] ?? 0.8
                ];
            } else {
                // Simple note name
                $frequencies[] = [
                    'frequency' => $noteFrequencies[$note] ?? 440,
                    'duration' => 0.25,
                    'velocity' => 0.8
                ];
            }
        }
        
        return $frequencies;
    }
    
    /**
     * Create binaural beats for meditation/focus
     */
    public function createBinauralBeat($baseFrequency, $beatFrequency, $duration = 30) {
        return [
            'type' => 'binaural',
            'leftFrequency' => $baseFrequency,
            'rightFrequency' => $baseFrequency + $beatFrequency,
            'duration' => $duration,
            'envelope' => [
                'attack' => 2.0,  // Gentle fade in
                'decay' => 0,
                'sustain' => 1.0,
                'release' => 2.0  // Gentle fade out
            ],
            'volume' => 0.3, // Lower volume for comfort
            'message' => 'Focus with Koshik\'s binaural beats'
        ];
    }
    
    /**
     * Generate nature sounds - Koshik's environment
     */
    public function createNatureSound($type = 'jungle') {
        $natureSounds = [
            'jungle' => [
                'layers' => [
                    ['type' => 'noise', 'filter' => 'lowpass', 'frequency' => 800, 'volume' => 0.3],
                    ['type' => 'chirps', 'pattern' => 'random', 'density' => 0.7],
                    ['type' => 'rustling', 'intensity' => 0.5],
                    ['type' => 'distant_trumpets', 'probability' => 0.1]
                ],
                'ambience' => 'humid',
                'message' => 'Koshik remembers the jungle'
            ],
            'savanna' => [
                'layers' => [
                    ['type' => 'wind', 'intensity' => 0.4],
                    ['type' => 'grass', 'movement' => 0.6],
                    ['type' => 'birds', 'distance' => 'far'],
                    ['type' => 'insects', 'activity' => 'low']
                ],
                'ambience' => 'dry',
                'message' => 'The vast savanna calls'
            ],
            'rain' => [
                'layers' => [
                    ['type' => 'rain', 'intensity' => 0.7],
                    ['type' => 'thunder', 'probability' => 0.05],
                    ['type' => 'drops', 'surface' => 'leaves']
                ],
                'ambience' => 'wet',
                'message' => 'Koshik enjoys the rain'
            ]
        ];
        
        return $natureSounds[$type] ?? $natureSounds['jungle'];
    }
    
    /**
     * Create ASMR sounds - Gentle audio triggers
     */
    public function createASMR($trigger = 'whisper') {
        $asmrTriggers = [
            'whisper' => [
                'type' => 'voice',
                'processing' => ['eq' => 'high_boost', 'compression' => 'gentle'],
                'proximity' => 'close',
                'movement' => 'binaural_pan'
            ],
            'tapping' => [
                'type' => 'percussive',
                'pattern' => 'rhythmic',
                'material' => 'wood',
                'spacing' => 'irregular'
            ],
            'brushing' => [
                'type' => 'friction',
                'texture' => 'soft',
                'speed' => 'slow',
                'direction' => 'circular'
            ],
            'crinkling' => [
                'type' => 'texture',
                'material' => 'paper',
                'intensity' => 'gentle',
                'randomness' => 0.7
            ]
        ];
        
        return $asmrTriggers[$trigger] ?? $asmrTriggers['whisper'];
    }
    
    /**
     * Generate elephant communication sounds
     */
    public function elephantCommunication($type = 'greeting') {
        $communications = [
            'greeting' => [
                'rumble' => ['frequency' => 20, 'duration' => 2, 'modulation' => 5],
                'trumpet' => ['frequency' => 300, 'duration' => 0.5, 'harmonics' => 5],
                'message' => 'annyong - elephant style!'
            ],
            'warning' => [
                'rumble' => ['frequency' => 15, 'duration' => 3, 'intensity' => 0.9],
                'trumpet' => ['frequency' => 400, 'duration' => 1, 'urgency' => 'high'],
                'message' => 'aniya! danger!'
            ],
            'affection' => [
                'rumble' => ['frequency' => 25, 'duration' => 1.5, 'warmth' => 0.8],
                'chirp' => ['frequency' => 800, 'duration' => 0.2, 'repetitions' => 3],
                'message' => 'saranghae - elephant love'
            ],
            'playful' => [
                'squeaks' => ['frequency' => [600, 800, 1000], 'duration' => 0.3],
                'rumble' => ['frequency' => 30, 'duration' => 1, 'variation' => 0.6],
                'message' => 'nolda! let\'s play!'
            ]
        ];
        
        return $communications[$type] ?? $communications['greeting'];
    }
    
    /**
     * Create audio visualization data
     */
    public function generateVisualizationData($audio, $type = 'waveform') {
        $visualizations = [
            'waveform' => $this->generateWaveformData($audio),
            'spectrum' => $this->generateSpectrumData($audio),
            'levels' => $this->generateLevelMeters($audio),
            'psychedelic' => $this->generatePsychedelicData($audio)
        ];
        
        return $visualizations[$type] ?? $visualizations['waveform'];
    }
    
    /**
     * Generate waveform visualization data
     */
    private function generateWaveformData($audio) {
        return [
            'type' => 'waveform',
            'samples' => 1024,
            'colors' => ['primary' => '#3498db', 'secondary' => '#2ecc71'],
            'style' => 'smooth',
            'animation' => 'flow'
        ];
    }
    
    /**
     * Generate spectrum analyzer data
     */
    private function generateSpectrumData($audio) {
        return [
            'type' => 'spectrum',
            'bands' => 32,
            'scale' => 'logarithmic',
            'colors' => ['low' => '#e74c3c', 'mid' => '#f39c12', 'high' => '#3498db'],
            'decay' => 0.85
        ];
    }
    
    /**
     * Generate level meter data
     */
    private function generateLevelMeters($audio) {
        return [
            'type' => 'levels',
            'channels' => 2,
            'peak_hold' => true,
            'colors' => ['safe' => '#2ecc71', 'warning' => '#f39c12', 'danger' => '#e74c3c'],
            'decay_rate' => 0.95
        ];
    }
    
    /**
     * Generate psychedelic visualization data
     */
    private function generatePsychedelicData($audio) {
        return [
            'type' => 'psychedelic',
            'particles' => 500,
            'react_to' => ['frequency', 'amplitude', 'rhythm'],
            'color_mode' => 'rainbow',
            'effects' => ['trails', 'bloom', 'distortion']
        ];
    }
    
    /**
     * Language learning mode - Teach Koshik new words
     */
    public function learnNewWord($word, $pronunciation, $language = 'ko', $context = []) {
        // Add to vocabulary
        if (!isset($this->vocabulary[$language])) {
            $this->vocabulary[$language] = [];
        }
        
        $this->vocabulary[$language][$word] = $pronunciation;
        
        // Create learning record
        $learning = [
            'word' => $word,
            'pronunciation' => $pronunciation,
            'language' => $language,
            'learned_at' => time(),
            'context' => $context,
            'practice_count' => 0
        ];
        
        // Store in memory
        $learningKey = "koshik_learning_{$language}_{$word}";
        Memory::remember($learningKey, $learning, 86400 * 365); // Remember for a year
        
        // Update vocabulary cache
        Memory::remember('koshik_vocabulary', $this->vocabulary, 86400);
        
        return [
            'success' => true,
            'message' => "Koshik learned: {$word} = {$pronunciation}",
            'total_words' => count($this->vocabulary[$language])
        ];
    }
    
    /**
     * Practice pronunciation - Koshik practices speaking
     */
    public function practicePronunciation($word, $language = 'ko') {
        if (!isset($this->vocabulary[$language][$word])) {
            return [
                'success' => false,
                'message' => 'Koshik doesn\'t know this word yet'
            ];
        }
        
        $pronunciation = $this->vocabulary[$language][$word];
        
        // Generate practice session
        $practice = [
            'word' => $word,
            'pronunciation' => $pronunciation,
            'slow_speed' => $this->generateTTSScript($pronunciation, $language, ['rate' => 0.6]),
            'normal_speed' => $this->generateTTSScript($pronunciation, $language, ['rate' => 0.9]),
            'with_emphasis' => $this->generateTTSScript($pronunciation, $language, ['pitch' => 1.2, 'rate' => 0.8])
        ];
        
        // Update practice count
        $learningKey = "koshik_learning_{$language}_{$word}";
        $learning = Memory::recall($learningKey);
        if ($learning) {
            $learning['practice_count']++;
            Memory::remember($learningKey, $learning, 86400 * 365);
        }
        
        return $practice;
    }
    
    /**
     * Generate audio for games and interactions
     */
    public function gameAudio($action, $options = []) {
        $gameAudios = [
            'start' => $this->createGameStartSound(),
            'win' => $this->createVictorySound(),
            'lose' => $this->createDefeatSound(),
            'score' => $this->createScoreSound($options['points'] ?? 10),
            'powerup' => $this->createPowerUpSound(),
            'countdown' => $this->createCountdownSound($options['seconds'] ?? 3),
            'menu_hover' => $this->createMenuHoverSound(),
            'menu_select' => $this->createMenuSelectSound()
        ];
        
        return $gameAudios[$action] ?? $this->notify('default');
    }
    
    /**
     * Create game start sound
     */
    private function createGameStartSound() {
        return [
            'type' => 'sequence',
            'notes' => [
                ['frequency' => 261.63, 'duration' => 0.1], // C4
                ['frequency' => 329.63, 'duration' => 0.1], // E4
                ['frequency' => 392.00, 'duration' => 0.1], // G4
                ['frequency' => 523.25, 'duration' => 0.2], // C5
            ],
            'waveform' => 'square',
            'volume' => $this->volume * 0.8,
            'message' => 'Game start! Fighting!'
        ];
    }
    
    /**
     * Create victory fanfare
     */
    private function createVictorySound() {
        return [
            'type' => 'fanfare',
            'notes' => [
                ['frequency' => 523.25, 'duration' => 0.2], // C5
                ['frequency' => 523.25, 'duration' => 0.1], // C5
                ['frequency' => 523.25, 'duration' => 0.1], // C5
                ['frequency' => 523.25, 'duration' => 0.4], // C5
                ['frequency' => 415.30, 'duration' => 0.3], // G#4
                ['frequency' => 466.16, 'duration' => 0.3], // A#4
                ['frequency' => 523.25, 'duration' => 0.5], // C5
            ],
            'harmony' => true,
            'effects' => ['reverb' => ['roomSize' => 0.9]],
            'message' => 'choah! You win!'
        ];
    }
    
    /**
     * Create defeat sound
     */
    private function createDefeatSound() {
        return [
            'type' => 'sequence',
            'notes' => [
                ['frequency' => 392.00, 'duration' => 0.3], // G4
                ['frequency' => 349.23, 'duration' => 0.3], // F4
                ['frequency' => 293.66, 'duration' => 0.3], // D4
                ['frequency' => 261.63, 'duration' => 0.5], // C4
            ],
            'waveform' => 'triangle',
            'envelope' => $this->synthesisParams['envelopes']['pad'],
            'volume' => $this->volume * 0.6,
            'message' => 'aniya... try again!'
        ];
    }
    
    /**
     * Create score sound based on points
     */
    private function createScoreSound($points) {
        $baseFreq = 440 + ($points * 20); // Higher pitch for more points
        return [
            'type' => 'chord',
            'frequencies' => [$baseFreq, $baseFreq * 1.25, $baseFreq * 1.5],
            'duration' => 0.2,
            'waveform' => 'sine',
            'volume' => $this->volume * 0.7,
            'message' => "choah! {$points} points!"
        ];
    }
    
    /**
     * Create power-up sound
     */
    private function createPowerUpSound() {
        return [
            'type' => 'sweep',
            'startFrequency' => 200,
            'endFrequency' => 800,
            'duration' => 0.5,
            'waveform' => 'sawtooth',
            'filter' => 'lowpass',
            'volume' => $this->volume * 0.8,
            'message' => 'himdeulda! Power up!'
        ];
    }
    
    /**
     * Create countdown sound
     */
    private function createCountdownSound($seconds) {
        $sounds = [];
        for ($i = $seconds; $i > 0; $i--) {
            $sounds[] = [
                'frequency' => 440,
                'duration' => 0.1,
                'delay' => ($seconds - $i) * 1.0
            ];
        }
        // Final beep
        $sounds[] = [
            'frequency' => 880,
            'duration' => 0.5,
            'delay' => $seconds * 1.0
        ];
        
        return [
            'type' => 'countdown',
            'sounds' => $sounds,
            'volume' => $this->volume,
            'message' => 'sijak! Start!'
        ];
    }
    
    /**
     * Create menu hover sound
     */
    private function createMenuHoverSound() {
        return [
            'type' => 'simple',
            'frequency' => 600,
            'duration' => 0.05,
            'waveform' => 'sine',
            'volume' => $this->volume * 0.3,
            'message' => 'menu hover'
        ];
    }
    
    /**
     * Create menu select sound
     */
    private function createMenuSelectSound() {
        return [
            'type' => 'sequence',
            'notes' => [
                ['frequency' => 523.25, 'duration' => 0.05], // C5
                ['frequency' => 659.25, 'duration' => 0.1],  // E5
            ],
            'waveform' => 'square',
            'volume' => $this->volume * 0.5,
            'message' => 'menu select'
        ];
    }
    
    /**
     * Accessibility features - Screen reader integration
     */
    public function screenReaderAnnounce($text, $priority = 'polite') {
        return [
            'type' => 'screen_reader',
            'text' => $text,
            'priority' => $priority, // 'polite' or 'assertive'
            'language' => $this->language,
            'voice' => $this->selectVoice('koshik', $this->language),
            'fallback' => $this->generateTTSScript($text, $this->language)
        ];
    }
    
    /**
     * Batch audio generation for performance
     */
    public function batchGenerateAudio($requests) {
        $batch = [
            'id' => 'koshik_batch_' . uniqid(),
            'requests' => [],
            'total_duration' => 0
        ];
        
        foreach ($requests as $request) {
            $audio = $this->processAudioRequest($request);
            $batch['requests'][] = $audio;
            $batch['total_duration'] += $audio['duration'] ?? 0;
        }
        
        // Cache batch for quick retrieval
        Memory::remember("koshik_batch_{$batch['id']}", $batch, 300);
        
        return $batch;
    }
    
    /**
     * Process individual audio request
     */
    private function processAudioRequest($request) {
        switch ($request['type']) {
            case 'speak':
                return $this->speak($request['message'], $request['options'] ?? []);
            case 'notify':
                return $this->notify($request['sound'], $request['options'] ?? []);
            case 'melody':
                return $this->playMelody($request['notes'], $request['options'] ?? []);
            default:
                return $this->notify('default');
        }
    }
    
    /**
     * Export audio configuration for client
     */
    public function exportConfiguration() {
        return [
            'version' => '2.0',
            'capabilities' => [
                'tts' => true,
                'synthesis' => true,
                'effects' => array_keys($this->synthesisParams['effects']),
                'languages' => array_keys($this->vocabulary),
                'melodies' => true,
                'nature_sounds' => true,
                'binaural' => true,
                'games' => true
            ],
            'settings' => [
                'volume' => $this->volume,
                'language' => $this->language,
                'voice_profiles' => $this->voiceProfiles
            ],
            'vocabulary_stats' => $this->getVocabularyStats(),
            'api_endpoint' => '/api/koshik.php'
        ];
    }
} 